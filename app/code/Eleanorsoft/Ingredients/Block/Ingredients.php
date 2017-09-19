<?php

namespace Eleanorsoft\Ingredients\Block;

class Ingredients extends \Magento\Catalog\Block\Product\View
{
    private $_productRepository;

    public function loadIngredientProduct($ingredient)
    {
        if(!$this->_productRepository) {
            $this->_productRepository = \Magento\Framework\App\ObjectManager::getInstance()
                 ->get('\Magento\Catalog\Model\ProductRepository');
        }

        return $this->_productRepository->getById($ingredient->getId());
    }
}