<?php

namespace Eleanorsoft\AheadworksSarp\Block\Customer\Subscription\Info;
use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Aheadworks\Sarp\Block\Customer\Subscription\Info\Products as BaseProducts;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\Product\Url as ProductUrl;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Products
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Products extends BaseProducts
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    protected $imageBuilder;

    /**
     * Products constructor.
     * @param Context $context
     * @param ProfileRepositoryInterface $profileRepository
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param ProductUrl $productUrl
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        ProfileRepositoryInterface $profileRepository,
        Session $customerSession,
        ProductRepositoryInterface $productRepository,
        ProductUrl $productUrl,
        PriceCurrencyInterface $priceCurrency,
        ImageBuilder $imageBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $profileRepository, $customerSession, $productRepository, $productUrl, $priceCurrency, $data);
        $this->productRepository = $productRepository;
        $this->imageBuilder = $imageBuilder;
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @param $id
     * @return ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProduct($id)
    {
        return $this->productRepository->getById($id);
    }

    /**
     * Retrieve product image
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $imageId
     * @param array $attributes
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }
}