<?php

namespace Eleanorsoft\OurPromise\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Item
 * @package Eleanorsoft\OurPromise\Model
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
        $this->_init('Eleanorsoft\OurPromise\Model\Resource\Item');
    }
}