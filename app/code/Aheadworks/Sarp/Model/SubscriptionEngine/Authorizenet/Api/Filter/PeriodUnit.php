<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Authorizenet\Api\Filter;

use Aheadworks\Sarp\Model\SubscriptionPlan\Source\BillingPeriod as PeriodUnitSource;

/**
 * Class PeriodUnit
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Authorizenet\Api\Filter
 */
class PeriodUnit implements \Zend_Filter_Interface
{
    /**
     * {@inheritdoc}
     */
    public function filter($value)
    {
        switch ($value) {
            case PeriodUnitSource::DAY:
                return 'days';
            case PeriodUnitSource::MONTH:
                return 'months';
            default:
                break;
        }
        return '';
    }
}
