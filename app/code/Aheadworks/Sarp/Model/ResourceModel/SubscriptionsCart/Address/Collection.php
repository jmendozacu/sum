<?php
namespace Aheadworks\Sarp\Model\ResourceModel\SubscriptionsCart\Address;

use Aheadworks\Sarp\Model\SubscriptionsCart\Address;
use Aheadworks\Sarp\Model\ResourceModel\SubscriptionsCart\Address as AddressResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Aheadworks\Sarp\Model\ResourceModel\SubscriptionsCart\Address
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(Address::class, AddressResource::class);
    }
}
