<?php

namespace Atak\Praise\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Item
 * @package Atak\Praise\Model
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
        $this->_init('Atak\Praise\Model\Resource\Item');
    }
}