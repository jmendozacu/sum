<?php
namespace Atak\Testimonials\Model\Resource\Item;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Atak\Testimonials\Model\Item', 'Atak\Testimonials\Model\Resource\Item');
    }
}