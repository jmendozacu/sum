<?php
namespace Aheadworks\Sarp\Model\ResourceModel\SubscriptionsCart;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Item
 * @package Aheadworks\Sarp\Model\ResourceModel\SubscriptionsCart
 */
class Item extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('aw_sarp_subscriptions_cart_item', 'item_id');
    }
}
