<?php

namespace Atak\Videoblocks\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Item
 * @package Atak\Videoblocks\Model
 *
 *
 * @method getImage()
 * @method getName()
 * @method getText()
 * @method getSubtitle()
 */
class Item extends AbstractModel
{
    const VIDEO_POSITION_LEFT = 'left';
    const VIDEO_POSITION_RIGHT = 'right';

    public function _construct() {
        $this->_init('Atak\Videoblocks\Model\Resource\Item');
    }
}