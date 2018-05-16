<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;
use Eleanorsoft\AheadworksSarp\Controller\AbstractInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;


/**
 * Class AddProduct
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class AddProduct extends AbstractInfo
{

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * AddProduct constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param Url $productUrl
     * @param Json $json
     * @param Image $imageHelper
     */
    public function __construct
    (
        Context $context,
        ProductRepositoryInterface $productRepository,
        Url $productUrl,
        Json $json,
        Image $imageHelper
    )
    {
        parent::__construct($context, $productRepository, $productUrl, $json);
        $this->imageHelper = $imageHelper;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $product_id = $this->getRequest()->getPost('product_id');

        if ($product_id) {

            $product = $this->productRepository->getById($product_id);

            $productData = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'qty' => 1,
                'price' => $product->getFinalPrice(),
                'image' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
                'product_url' => $this->productUrl->getUrl($product),
                'item_total' => $product->getFinalPrice()
            ];

            return $this->json->setData($productData);
        }

    }
}