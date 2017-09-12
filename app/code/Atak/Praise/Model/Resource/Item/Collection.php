<?php
namespace Atak\Praise\Model\Resource\Item;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Atak\Praise\Model\Item', 'Atak\Praise\Model\Resource\Item');
    }
}