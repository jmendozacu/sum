<?php
namespace Aheadworks\Sarp\Model\ResourceModel\Profile;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Order
 * @package Aheadworks\Sarp\Model\ResourceModel\Profile
 */
class Order extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('aw_sarp_profile_order', 'id');
    }
}
