<?php

namespace Eleanorsoft\Ingredients\Block;

class Listing extends \Magento\Framework\View\Element\Template
{
    protected $_groupedIngredients;

    public function __construct(
        \Eleanorsoft\Ingredients\Model\Ingredients $ingredients,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->_groupedIngredients  = $ingredients->getGroupedIngredients();

        parent::__construct($context);
    }

    public function getIngredients()
    {
        return $this->_groupedIngredients;
    }

    public function getIngredientImageUrl($product)
    {
        return $this->getUrl('pub/media/catalog').'product'.$product->getImage();
    }
}