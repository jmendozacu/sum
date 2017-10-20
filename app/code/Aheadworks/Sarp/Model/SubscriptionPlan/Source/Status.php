<?php
namespace Aheadworks\Sarp\Model\SubscriptionPlan\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package Aheadworks\Sarp\Model\SubscriptionPlan\Source
 */
class Status implements ArrayInterface
{
    /**
     * 'Enabled' status
     */
    const ENABLED = 1;

    /**
     * 'Disabled' status
     */
    const DISABLED = 0;

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
                    'value' => self::DISABLED,
                    'label' => __('Disabled')
                ],
                [
                    'value' => self::ENABLED,
                    'label' => __('Enabled')
                ]
            ];
        }
        return $this->options;
    }
}
