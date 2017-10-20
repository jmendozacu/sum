<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Authorizenet\Source;

use Aheadworks\Sarp\Model\SubscriptionPlan\Source\BillingPeriod as BillingPeriodSource;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class BillingPeriod
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Authorizenet\Source
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
                    'value' => BillingPeriodSource::MONTH,
                    'label' => __('Month')
                ]
            ];
        }
        return $this->options;
    }
}
