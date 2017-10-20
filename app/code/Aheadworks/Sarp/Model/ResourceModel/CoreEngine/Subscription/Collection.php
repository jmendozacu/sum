<?php
namespace Aheadworks\Sarp\Model\ResourceModel\CoreEngine\Subscription;

use Aheadworks\Sarp\Model\ResourceModel\CoreEngine\Subscription as SubscriptionResource;
use Aheadworks\Sarp\Model\SubscriptionEngine\Core\Subscription;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Aheadworks\Sarp\Model\ResourceModel\CoreEngine\Subscription
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = 'subscription_id';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(Subscription::class, SubscriptionResource::class);
    }
}
