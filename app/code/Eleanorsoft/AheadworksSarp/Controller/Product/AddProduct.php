<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;
use Eleanorsoft\AheadworksSarp\Controller\AbstractInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Directory\Model\Currency;

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
        $parent_id = $this->getRequest()->getPost('parent_id');

        if ($product_id) {

            $product = $this->productRepository->getById($product_id);
            $id = (int)$product->getId();
            $name = $product->getName();
            $price = $product->getFinalPrice();
            $image = $this->imageHelper->init($product, 'product_base_image')->getUrl();
            $product_url = $this->productUrl->getUrl($product);

            if ($parent_id) {
                $parent_product = $this->productRepository->getById($parent_id);
                $child_name = $name;
                $name = $parent_product->getName()  .   ": "    . $child_name;
                $product_url = $this->productUrl->getUrl($parent_product);
            }

            $productData = [
                'id' => $id,
                'name' => $name,
                'qty' => 1,
                'price' => $price,
                'price_int' => $price,
                'image' => $image,
                'product_url' => $product_url,
                'item_total' => $price
            ];

            return $this->json->setData($productData);
        }
    }
}