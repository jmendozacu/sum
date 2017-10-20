<?php
namespace Aheadworks\Sarp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class SubscriptionPlan
 * @package Magento\Blog\Model\ResourceModel
 */
class SubscriptionPlan extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('aw_sarp_subscription_plan', 'subscription_plan_id');
    }
}
