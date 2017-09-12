<?php

namespace Atak\Praise\Model\Resource;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Item
 * @package Atak\Praise\Model\Resource
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
        $this->_init('atak_praise','id');
    }
}