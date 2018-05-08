<?php

namespace Eleanorsoft\AheadworksSarp\Model\Config\Source\Customer\View;
use Aheadworks\Sarp\Api\Data\SubscriptionPlanInterface;
use Aheadworks\Sarp\Model\ResourceModel\SubscriptionPlan\CollectionFactory;


/**
 * Class Plans
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_AheadworksSarp
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Plan
{

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * Plan constructor.
     * @param CollectionFactory $collection
     */
    public function __construct
    (
        CollectionFactory $collection
    )
    {
        $this->collection = $collection;
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return array
     */
    public function toOptionArray()
    {

        $collection = $this->collection->create();

        $options = [];

        foreach ($collection->getItems() as $item) {/** @var $item SubscriptionPlanInterface */

            $billingPeriod = ucfirst($item->getBillingPeriod());
            $billingFrequency = $item->getBillingFrequency();

            $options[] =
                [
                    'label' => __("Every %1th %2",$billingFrequency, $billingPeriod),
                    'value' => $item->getSubscriptionPlanId()];
        }
        return $options;

    }

}