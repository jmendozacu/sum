<?php

namespace Eleanorsoft\Ingredients\Model\Product\Link\CollectionProvider;

class Ingredients implements \Magento\Catalog\Model\ProductLink\CollectionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLinkedProducts(\Magento\Catalog\Model\Product $product)
    {
        $products = $product->getIngredientsProducts();

        if (!isset($products)) {
            return [];
        }

        return $products;
    }
}