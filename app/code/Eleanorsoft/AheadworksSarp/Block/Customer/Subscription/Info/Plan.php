<?php

namespace Eleanorsoft\AheadworksSarp\Block\Customer\Subscription\Info;

use Aheadworks\Sarp\Api\ProfileRepositoryInterface;
use Aheadworks\Sarp\Block\Customer\Subscription\Info\Plan as BasePlan;
use Aheadworks\Sarp\Model\SubscriptionPlan\Source\BillingFrequency as BillingFrequencySource;
use Aheadworks\Sarp\Model\SubscriptionPlan\Source\BillingPeriod as BillingPeriodSource;
use Aheadworks\Sarp\Model\SubscriptionPlan\Source\RepeatPayments as RepeatPaymentsSource;
use Aheadworks\Sarp\Model\SubscriptionPlan\Source\RepeatPayments\Converter as RepeatPaymentsConverter;
use Eleanorsoft\AheadworksSarp\Model\Config\Source\Customer\View\Plan as PlanOptions;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Plan
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Plan extends BasePlan
{

    /**
     * @var PlanOptions
     */
    protected $plan;

    /**
     * Plan constructor.
     * @param Context $context
     * @param ProfileRepositoryInterface $profileRepository
     * @param Session $customerSession
     * @param PriceCurrencyInterface $priceCurrency
     * @param RepeatPaymentsConverter $repeatPaymentsConverter
     * @param BillingPeriodSource $billingPeriodSource
     * @param BillingFrequencySource $billingFrequencySource
     * @param RepeatPaymentsSource $repeatPaymentsSource
     * @param PlanOptions $plan
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        ProfileRepositoryInterface $profileRepository,
        Session $customerSession,
        PriceCurrencyInterface $priceCurrency,
        RepeatPaymentsConverter $repeatPaymentsConverter,
        BillingPeriodSource $billingPeriodSource,
        BillingFrequencySource $billingFrequencySource,
        RepeatPaymentsSource $repeatPaymentsSource,
        PlanOptions $plan,
        array $data = []
    )
    {
        parent::__construct($context, $profileRepository, $customerSession, $priceCurrency, $repeatPaymentsConverter, $billingPeriodSource, $billingFrequencySource, $repeatPaymentsSource, $data);
        $this->plan = $plan;
    }

    /**
     * todo: What is its purpose? What does it do?
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->plan->toOptionArray();
    }

    /**
     * Change repeat subscription plan
     *
     * @return string
     */
    public function getChangeRepeat()
    {
        $profileId = $this->getProfileId();

        return $this->_urlBuilder->getUrl(
            'aw_sarp/product/subscribe',
            [
                'es_active'=>'activate',
                'profile_id' => $profileId
            ]
        );
    }

    /**
     * Get profile ID
     *
     * @return int|null
     */
    private function getProfileId()
    {
        return $this->getRequest()->getParam('profile_id');
    }
}