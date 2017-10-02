<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionsCart\Item;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartItemInterface;
use Magento\Framework\Validator\AbstractValidator;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as TypeConfigurable;
use Magento\Bundle\Api\ProductOptionRepositoryInterface as BundleProductOptionRepository;
use Magento\Catalog\Model\Product;

/**
 * Class Validator
 * @package Aheadworks\Sarp\Model\SubscriptionsCart\Item
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class Validator extends AbstractValidator
{
    /**
     * @var StockStateInterface
     */
    private $stockState;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var BundleProductOptionRepository
     */
    private $bundleProductOptionRepository;

    /**
     * @param StockStateInterface $stockState
     * @param ProductRepositoryInterface $productRepository
     * @param BundleProductOptionRepository $bundleProductOptionRepository
     */
    public function __construct(
        StockStateInterface $stockState,
        ProductRepositoryInterface $productRepository,
        BundleProductOptionRepository $bundleProductOptionRepository
    ) {
        $this->stockState = $stockState;
        $this->productRepository = $productRepository;
        $this->bundleProductOptionRepository = $bundleProductOptionRepository;
    }

    /**
     * Returns true if and only if subscription cart item entity meets the validation requirements
     *
     * @param SubscriptionsCartItemInterface $item
     * @return bool
     */
    public function isValid($item)
    {
        $this->_clearMessages();

        if (!\Zend_Validate::is($item->getName(), 'NotEmpty')) {
            $this->_addMessages(['Name is required.']);
        }
        if (!\Zend_Validate::is($item->getQty(), 'NotEmpty')) {
            $this->_addMessages(['Qty is required.']);
        } elseif (!is_numeric($item->getQty()) || $item->getQty() <= 0) {
            $this->_addMessages(['Qty is incorrect.']);
        } else {
            /** @var Product $product */
            $product = $this->productRepository->getById($item->getProductId());
            $buyRequest = unserialize($item->getBuyRequest());
            $isValid = true;
            if ($product->getTypeId() == 'configurable' && isset($buyRequest['super_attribute'])) {
                $isValid = $this->isConfigurableProductAvailable($product, $item->getQty(), $buyRequest);
            } elseif ($product->getTypeId() == 'bundle' && isset($buyRequest['bundle_option'])) {
                $isValid = $this->isBundleProductAvailable($product, $item->getQty(), $buyRequest);
            } elseif (!$item->getParentItemId()) {
                $isValid = $this->isSimpleProductAvailable($product, $item->getQty());
            }
            if (!$isValid) {
                $this->_addMessages(['Such amount could not be ordered.']);
            }
        }
        if (!\Zend_Validate::is($item->getBuyRequest(), 'NotEmpty')) {
            $this->_addMessages(['Buy request is required.']);
        }

        return empty($this->getMessages());
    }

    /**
     * Is specified quantity of simple product available
     *
     * @param Product $product
     * @param int $qty
     * @return bool
     */
    private function isSimpleProductAvailable($product, $qty)
    {
        return $this->stockState->checkQty($product->getId(), $qty);
    }

    /**
     * Is specified quantity of configurable product available
     *
     * @param Product $product
     * @param int $qty
     * @param array $buyRequest
     * @return bool
     */
    private function isConfigurableProductAvailable($product, $qty, $buyRequest)
    {
        /** @var TypeConfigurable $productTypeInstance */
        $productTypeInstance = $product->getTypeInstance();
        $childProduct = $productTypeInstance->getProductByAttributes($buyRequest['super_attribute'], $product);

        return $this->isSimpleProductAvailable($childProduct, $qty);
    }

    /**
     * Is specified quantity of bundle product available
     *
     * @param Product $product
     * @param int $qty
     * @param array $buyRequest
     * @return bool
     */
    private function isBundleProductAvailable($product, $qty, $buyRequest)
    {
        $bundleOptions = $this->bundleProductOptionRepository->getList($product->getData('sku'));
        $isBundleAvailable = true;
        foreach ($buyRequest['bundle_option'] as $bundleOptionId => $bundleOptionValue) {
            foreach ($bundleOptions as $option) {
                $optionChecked = false;
                if ($option->getOptionId() == $bundleOptionId) {
                    foreach ($option->getProductLinks() as $productLink) {
                        if ($productLink->getId() == $bundleOptionValue) {
                            $childProduct = $this->productRepository->get($productLink->getSku());
                            $childProductQty = $productLink->getCanChangeQuantity()
                                ? $buyRequest['bundle_option_qty'][$bundleOptionId]
                                : $productLink->getQty();
                            $isBundleAvailable = $this->isSimpleProductAvailable(
                                $childProduct,
                                $qty * $childProductQty
                            );
                            $optionChecked = true;
                            break;
                        }
                    }
                    if ($optionChecked) {
                        break;
                    }
                }
            }
            if (!$isBundleAvailable) {
                return false;
            }
        }

        return true;
    }
}
