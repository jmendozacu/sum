<?php
namespace Atak\Videoblocks\Model\Resource\Item;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Atak\Videoblocks\Model\Item', 'Atak\Videoblocks\Model\Resource\Item');
    }
}