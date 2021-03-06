<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Source;

use Aheadworks\Sarp\Model\SubscriptionPlan\Source\BillingPeriod as BillingPeriodSource;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class BillingPeriod
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Source
 */
class BillingPeriod implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [
                [
                    'value' => BillingPeriodSource::DAY,
                    'label' => __('Day')
                ],
                [
                    'value' => BillingPeriodSource::WEEK,
                    'label' => __('Week')
                ],
                [
                    'value' => BillingPeriodSource::SEMI_MONTH,
                    'label' => __('SemiMonth')
                ],
                [
                    'value' => BillingPeriodSource::MONTH,
                    'label' => __('Month')
                ],
                [
                    'value' => BillingPeriodSource::YEAR,
                    'label' => __('Year')
                ]
            ];
        }
        return $this->options;
    }
}
