<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter;

/**
 * Class ToCents
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Api\Filter
 */
class ToCents implements \Zend_Filter_Interface
{
    /**
     * {@inheritdoc}
     */
    public function filter($value)
    {
        return sprintf('%d', $value * 100);
    }
}
