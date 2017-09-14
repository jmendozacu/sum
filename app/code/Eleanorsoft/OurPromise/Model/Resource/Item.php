<?php

namespace Eleanorsoft\OurPromise\Model\Resource;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
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
        $this->_init('eleanorsoft_ourpromise','id');
    }
}