<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter;

/**
 * Class ToUppercase
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter
 */
class ToUppercase implements \Zend_Filter_Interface
{
    /**
     * {@inheritdoc}
     */
    public function filter($value)
    {
        return strtoupper($value);
    }
}
