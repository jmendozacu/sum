<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\DataSource;

/**
 * Interface MapInterface
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\DataSource
 */
interface MapInterface
{
    /**
     * Return array of option map
     *
     * @return array Format: array(array('fromValue' =>  array('value' => '<value>', 'label' => '<label>'), ...), ...)
     */
    public function toOptionMapArray();
}
