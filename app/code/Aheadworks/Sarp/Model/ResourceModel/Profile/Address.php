<?php
namespace Aheadworks\Sarp\Model\ResourceModel\Profile;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Address
 * @package Aheadworks\Sarp\Model\ResourceModel\Profile
 */
class Address extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('aw_sarp_profile_address', 'address_id');
    }
}
