<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter;

/**
 * Class ToLowercase
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter
 */
class ToLowercase implements \Zend_Filter_Interface
{
    /**
     * {@inheritdoc}
     */
    public function filter($value)
    {
        return strtolower($value);
    }
}
