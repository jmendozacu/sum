<?php

namespace Eleanorsoft\Ingredients\Model;

class Product extends \Magento\Catalog\Model\Product
{
    /**
     * Retrieve array of product's ingredients
     *
     * @return array
     */
    public function getIngredientsProducts()
    {
        if (!$this->hasIngredientsProducts()) {
            $products = [];
            foreach ($this->getIngredientsProductCollection() as $product) {
                $products[] = $product;
            }
            $this->setIngredientsProducts($products);
        }
        return $this->getData('ingredients_products');
    }
    /**
     * Retrieve product's ingredients identifiers
     *
     * @return array
     */
    public function getIngredientsIds()
    {
        if (!$this->hasIngredientsProductIds()) {
            $ids = [];
            foreach ($this->getIngredientsProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setIngredientsProductIds($ids);
        }
        return $this->getData('ingredients_product_ids');
    }
    /**
     * Retrieve collection product's ingredients
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    public function getIngredientsProductCollection()
    {
        $collection = $this->getLinkInstance()->useIngredientsLinks()->getProductCollection()->setIsStrongMode();

        $collection->setProduct($this);
        return $collection;
    }
    /**
     * Retrieve collection ingredients link
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Collection
     */
    public function getIngredientsLinkCollection()
    {
        $collection = $this->getLinkInstance()->useIngredientsLinks()->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }
    
}