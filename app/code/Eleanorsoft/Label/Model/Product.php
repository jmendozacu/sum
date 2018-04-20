<?php

namespace Eleanorsoft\Label\Model;
use Eleanorsoft\Label\Helper\Data;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Backend\Media\EntryConverterPool;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Catalog\Pricing\Price\RegularPrice;
use Magento\Framework\Api\AttributeValueFactory;


/**
 * Class Product
 * Add label for product
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Product extends \Eleanorsoft\Ingredients\Model\Product
{

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Product constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataService
     * @param \Magento\Catalog\Model\Product\Url $url
     * @param \Magento\Catalog\Model\Product\Link $productLink
     * @param \Magento\Catalog\Model\Product\Configuration\Item\OptionFactory $itemOptionFactory
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterfaceFactory $stockItemFactory
     * @param \Magento\Catalog\Model\Product\OptionFactory $catalogProductOptionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $catalogProductStatus
     * @param \Magento\Catalog\Model\Product\Media\Config $catalogProductMediaConfig
     * @param \Magento\Catalog\Model\Product\Type $catalogProductType
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Catalog\Helper\Product $catalogProduct
     * @param \Magento\Catalog\Model\ResourceModel\Product $resource
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $resourceCollection
     * @param \Magento\Framework\Data\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry
     * @param \Magento\Catalog\Model\Indexer\Product\Flat\Processor $productFlatIndexerProcessor
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param \Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor
     * @param CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Catalog\Model\Product\Image\CacheFactory $imageCacheFactory
     * @param \Magento\Catalog\Model\ProductLink\CollectionProvider $entityCollectionProvider
     * @param \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider
     * @param \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory
     * @param \Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory
     * @param EntryConverterPool $mediaGalleryEntryConverterPool
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataService,
        \Magento\Catalog\Model\Product\Url $url,
        \Magento\Catalog\Model\Product\Link $productLink,
        \Magento\Catalog\Model\Product\Configuration\Item\OptionFactory $itemOptionFactory,
        \Magento\CatalogInventory\Api\Data\StockItemInterfaceFactory $stockItemFactory,
        \Magento\Catalog\Model\Product\OptionFactory $catalogProductOptionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $catalogProductStatus,
        \Magento\Catalog\Model\Product\Media\Config $catalogProductMediaConfig,
        \Magento\Catalog\Model\Product\Type $catalogProductType,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Helper\Product $catalogProduct,
        \Magento\Catalog\Model\ResourceModel\Product $resource,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $resourceCollection,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\Catalog\Model\Indexer\Product\Flat\Processor $productFlatIndexerProcessor,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        \Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Product\Image\CacheFactory $imageCacheFactory,
        \Magento\Catalog\Model\ProductLink\CollectionProvider $entityCollectionProvider,
        \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider,
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory,
        \Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory,
        EntryConverterPool $mediaGalleryEntryConverterPool,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor,
        Data $helper,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $storeManager,
            $metadataService,
            $url,
            $productLink,
            $itemOptionFactory,
            $stockItemFactory,
            $catalogProductOptionFactory,
            $catalogProductVisibility,
            $catalogProductStatus,
            $catalogProductMediaConfig,
            $catalogProductType,
            $moduleManager,
            $catalogProduct,
            $resource,
            $resourceCollection,
            $collectionFactory,
            $filesystem,
            $indexerRegistry,
            $productFlatIndexerProcessor,
            $productPriceIndexerProcessor,
            $productEavIndexerProcessor,
            $categoryRepository,
            $imageCacheFactory,
            $entityCollectionProvider,
            $linkTypeProvider,
            $productLinkFactory,
            $productLinkExtensionFactory,
            $mediaGalleryEntryConverterPool,
            $dataObjectHelper,
            $joinProcessor,
            $data
        );
        $this->helper = $helper;
    }

    /**
     * Is this product a new ?
     *
     * @return bool
     */
    public function isNew()
    {
        $new_category_id = $this->helper->getNewCategoryId();
        $ids_category_product = $this->getCategoryIds();
        $is_new = false;

        if (in_array($new_category_id, $ids_category_product)) {
            $is_new = true;
        }

        return $is_new;
    }

    /**
     * Is this product on sale ?
     *
     * @return bool
     */
    public function isOnSale()
    {
        $displayRegularPrice = $this->getPriceInfo()->getPrice(RegularPrice::PRICE_CODE)->getAmount()->getValue();
        $displayFinalPrice = $this->getPriceInfo()->getPrice(FinalPrice::PRICE_CODE)->getAmount()->getValue();

        return $displayFinalPrice < $displayRegularPrice;
    }
}