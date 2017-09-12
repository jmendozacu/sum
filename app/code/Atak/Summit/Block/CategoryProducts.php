<?php
namespace Atak\Summit\Block;

use Magento\Catalog\Model\ResourceModel\Product\Collection;

/**
 * Class CategoryProducts
 * Displays products from specific category.
 * Expects an argument `category_id`
 *
 * @package Atak\Summit\Block
 */
class CategoryProducts extends \Magento\Catalog\Block\Product\AbstractProduct
{
    public $_itemsCollection;
    public $_storeManager;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    public $categoryFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->_storeManager = $context->getStoreManager();

        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\Category
     */
    public function getCategory()
    {
        $categoryId = $this->getCategoryId();
        $category = $this->categoryFactory->create()->load($categoryId);
        return $category;
    }

    public function getProductCollection()
    {
        return $this->getCategory()->getProductCollection()->addAttributeToSelect('*');
    }
}