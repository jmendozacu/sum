<?php

namespace Atak\Videoblocks\Model\Resource;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Item
 * @package Atak\Videoblocks\Model\Resource
 *
 */
class Item extends  AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        /* Custom Table Name */
        $this->_init('atak_videoblocks','id');
    }
}