<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;
use Aheadworks\Sarp\Api\Data\ProfileItemInterface;
use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Eleanorsoft\AheadworksSarp\Controller\AbstractInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product\Url as ProductUrl;
use Magento\Directory\Model\Currency;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;


/**
 * Class Info
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Info extends AbstractInfo
{

    /**
     * @var ProfileRepositoryInterface
     */
    protected $profileRepository;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * Info constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param ProductUrl $productUrl
     * @param ProfileRepositoryInterface $profileRepository
     * @param Json $json
     * @param Image $imageHelper
     * @param Currency $currency
     */
    public function __construct
    (
        Context $context,
        ProductRepositoryInterface $productRepository,
        ProductUrl $productUrl,
        ProfileRepositoryInterface $profileRepository,
        Json $json,
        Image $imageHelper
    )
    {
        parent::__construct($context, $productRepository, $productUrl, $json);
        $this->profileRepository = $profileRepository;
        $this->imageHelper = $imageHelper;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $profileId = $this->getRequest()->getParam('profile_id');

        if ($profileId) {

            $profile = $this->profileRepository->get($profileId);
            $productData = [];

            foreach ($profile->getItems() as $item) { /** @var ProfileItemInterface $item  */
                $product = $this->productRepository->getById($item->getProductId());
                $productData[] = [
                    'id' => (int)$product->getId(),
                    'name' => $item->getName(),
                    'qty' => $item->getQty(),
                    'price' => $product->getFinalPrice(),
                    'price_int' => $product->getFinalPrice(),
                    'image' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
                    'product_url' => $this->productUrl->getUrl($product),
                    'item_total' => $item->getQty() * $product->getFinalPrice()
                ];
            }
            return $this->json->setData($productData);
        }
    }
}