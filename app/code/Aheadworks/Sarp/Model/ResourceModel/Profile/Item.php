<?php
namespace Aheadworks\Sarp\Model\ResourceModel\Profile;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Item
 * @package Aheadworks\Sarp\Model\ResourceModel\Profile
 */
class Item extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('aw_sarp_profile_item', 'item_id');
    }
}
