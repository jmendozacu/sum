<?php
namespace Eleanorsoft\OurPromise\Model\Resource\Item;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Eleanorsoft\OurPromise\Model\Item', 'Eleanorsoft\OurPromise\Model\Resource\Item');
    }
}