<?php

namespace Eleanorsoft\Ingredients\Model\Catalog\Product\Link;

class Proxy extends \Magento\Catalog\Model\Product\Link\Proxy
{
    /**
     * {@inheritdoc}
     */
    public function useIngredientsLinks()
    {
        return $this->_getSubject()->useIngredientsLinks();
    }
}