<?php
namespace Aheadworks\Sarp\Block\Cart;

/**
 * Class Link
 * @package Aheadworks\Sarp\Block\Cart
 */
class Link extends \Magento\Framework\View\Element\Template
{
    /**
     * Get subscription cart url
     *
     * @return string
     */
    public function getCartUrl()
    {
        return $this->_urlBuilder->getUrl('aw_sarp/cart/index');
    }
}
