<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionsCart;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Downloadable\Model\Product\Type as DownloadableType;
use Magento\Framework\Validator\AbstractValidator;

/**
 * Class CheckoutValidator
 * @package Aheadworks\Sarp\Model\SubscriptionsCart
 */
class CheckoutValidator extends AbstractValidator
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerSession $customerSession
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CustomerSession $customerSession
    ) {
        $this->productRepository = $productRepository;
        $this->customerSession = $customerSession;
    }

    /**
     * Returns true if and only if subscriptions cart is valid for checkout
     *
     * @param SubscriptionsCartInterface $cart
     * @return bool
     */
    public function isValid($cart)
    {
        $this->_clearMessages();

        if (!\Zend_Validate::is($cart->getItems(), 'NotEmpty')) {
            $this->_addMessages(['Subscription cart is empty.']);
            return false;
        }
        if (!\Zend_Validate::is($cart->getSubscriptionPlanId(), 'NotEmpty')) {
            $this->_addMessages(['Please select subscription plan.']);
        }
        if (!$this->customerSession->isLoggedIn()
            && $this->isCartContainsDownloadableProduct($cart)
        ) {
            $this->_addMessages(['Guest checkout is not allowed for downloadable products.']);
        }

        return empty($this->getMessages());
    }

    /**
     * Check if cart contains downloadable product
     *
     * @param SubscriptionsCartInterface $cart
     * @return bool
     */
    private function isCartContainsDownloadableProduct($cart)
    {
        foreach ($cart->getItems() as $item) {
            $product = $this->productRepository->getById($item->getProductId());
            if ($product->getTypeId() == DownloadableType::TYPE_DOWNLOADABLE) {
                return true;
            }
        }
        return false;
    }
}
