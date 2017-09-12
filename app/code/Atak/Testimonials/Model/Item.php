<?php

namespace Atak\Testimonials\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Item
 * @package Atak\Testimonials\Model
 *
 *
 * @method getImage()
 * @method getName()
 * @method getText()
 * @method getSubtitle()
 */
class Item extends AbstractModel
{
    public function _construct() {
        $this->_init('Atak\Testimonials\Model\Resource\Item');
    }
}