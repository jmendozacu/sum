<?php
namespace Aheadworks\Sarp\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ProfileInterface
 * @package Aheadworks\Sarp\Api\Data
 */
interface ProfileInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array.
     * Identical to the name of the getter in snake case
     */
    const PROFILE_ID = 'profile_id';
    const STORE_ID = 'store_id';
    const INCREMENT_ID = 'increment_id';
    const REFERENCE_ID = 'reference_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const STATUS = 'status';
    const ENGINE_CODE = 'engine_code';
    const PAYMENT_METHOD_CODE = 'payment_method_code';
    const PAYMENT_METHOD_TITLE = 'payment_method_title';
    const LAST_ORDER_ID = 'last_order_id';
    const LAST_ORDER_DATE = 'last_order_date';
    const SUBSCRIPTION_PLAN_ID = 'subscription_plan_id';
    const SUBSCRIPTION_PLAN_NAME = 'subscription_plan_name';
    const BILLING_PERIOD = 'billing_period';
    const BILLING_FREQUENCY = 'billing_frequency';
    const TOTAL_BILLING_CYCLES = 'total_billing_cycles';
    const IS_INITIAL_FEE_ENABLED = 'is_initial_fee_enabled';
    const IS_TRIAL_PERIOD_ENABLED = 'is_trial_period_enabled';
    const TRIAL_TOTAL_BILLING_CYCLES = 'trial_total_billing_cycles';
    const START_DATE = 'start_date';
    const IS_CART_VIRTUAL = 'is_cart_virtual';
    const ITEMS = 'items';
    const INNER_ITEMS = 'inner_items';
    const ADDRESSES = 'addresses';
    const CUSTOMER_ID = 'customer_id';
    const CUSTOMER = 'customer';
    const CUSTOMER_EMAIL = 'customer_email';
    const CUSTOMER_GROUP_ID = 'customer_group_id';
    const CUSTOMER_FULLNAME = 'customer_fullname';
    const CUSTOMER_PREFIX = 'customer_prefix';
    const CUSTOMER_FIRSTNAME = 'customer_firstname';
    const CUSTOMER_MIDDLENAME = 'customer_middlename';
    const CUSTOMER_LASTNAME = 'customer_lastname';
    const CUSTOMER_SUFFIX = 'customer_suffix';
    const CUSTOMER_DOB = 'customer_dob';
    const CUSTOMER_IS_GUEST = 'customer_is_guest';
    const SHIPPING_METHOD = 'shipping_method';
    const SHIPPING_DESCRIPTION = 'shipping_description';
    const GLOBAL_CURRENCY_CODE = 'global_currency_code';
    const BASE_CURRENCY_CODE = 'base_currency_code';
    const PROFILE_CURRENCY_CODE = 'profile_currency_code';
    const BASE_TO_GLOBAL_RATE = 'base_to_global_rate';
    const BASE_TO_PROFILE_RATE = 'base_to_profile_rate';
    const GRAND_TOTAL = 'grand_total';
    const BASE_GRAND_TOTAL = 'base_grand_total';
    const SUBTOTAL = 'subtotal';
    const BASE_SUBTOTAL = 'base_subtotal';
    const SHIPPING_AMOUNT = 'shipping_amount';
    const BASE_SHIPPING_AMOUNT = 'base_shipping_amount';
    const TAX_AMOUNT = 'tax_amount';
    const BASE_TAX_AMOUNT = 'base_tax_amount';
    const TRIAL_SUBTOTAL = 'trial_subtotal';
    const BASE_TRIAL_SUBTOTAL = 'base_trial_subtotal';
    const TRIAL_TAX_AMOUNT = 'trial_tax_amount';
    const BASE_TRIAL_TAX_AMOUNT = 'base_trial_tax_amount';
    const INITIAL_FEE = 'initial_fee';
    const BASE_INITIAL_FEE = 'base_initial_fee';
    const REMOTE_IP = 'remote_ip';
    /**#@-*/

    /**
     * Get profile ID
     *
     * @return int|null
     */
    public function getProfileId();

    /**
     * Set profile ID
     *
     * @param int $profileId
     * @return $this
     */
    public function setProfileId($profileId);

    /**
     * Get store ID
     *
     * @return int
     */
    public function getStoreId();

    /**
     * Set store ID
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * Get increment ID
     *
     * @return string
     */
    public function getIncrementId();

    /**
     * Set increment ID
     *
     * @param string $incrementId
     * @return $this
     */
    public function setIncrementId($incrementId);

    /**
     * Get reference ID
     *
     * @return string
     */
    public function getReferenceId();

    /**
     * Set reference ID
     *
     * @param string $referenceId
     * @return $this
     */
    public function setReferenceId($referenceId);

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set creation time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set update time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get engine code
     *
     * @return string
     */
    public function getEngineCode();

    /**
     * Set engine codes
     *
     * @param string $engineCode
     * @return $this
     */
    public function setEngineCode($engineCode);

    /**
     * Get payment method code
     *
     * @return string
     */
    public function getPaymentMethodCode();

    /**
     * Set payment method code
     *
     * @param string $methodCode
     * @return $this
     */
    public function setPaymentMethodCode($methodCode);

    /**
     * Get payment method title
     *
     * @return string
     */
    public function getPaymentMethodTitle();

    /**
     * Set payment method title
     *
     * @param string $methodTitle
     * @return $this
     */
    public function setPaymentMethodTitle($methodTitle);

    /**
     * Get last order ID
     *
     * @return int|null
     */
    public function getLastOrderId();

    /**
     * Set last order ID
     *
     * @param int $lastOrderId
     * @return $this
     */
    public function setLastOrderId($lastOrderId);

    /**
     * Get last order date
     *
     * @return string|null
     */
    public function getLastOrderDate();

    /**
     * Set last order date
     *
     * @param string $lastOrderDate
     * @return $this
     */
    public function setLastOrderDate($lastOrderDate);

    /**
     * Get subscription plan ID
     *
     * @return int
     */
    public function getSubscriptionPlanId();

    /**
     * Set subscription plan ID
     *
     * @param int $planId
     * @return $this
     */
    public function setSubscriptionPlanId($planId);

    /**
     * Get subscription plan name
     *
     * @return string
     */
    public function getSubscriptionPlanName();

    /**
     * Set subscription plan name
     *
     * @param string $subscriptionPlanName
     * @return $this
     */
    public function setSubscriptionPlanName($subscriptionPlanName);

    /**
     * Get billing period
     *
     * @return string
     */
    public function getBillingPeriod();

    /**
     * Set billing period
     *
     * @param string $billingPeriod
     * @return $this
     */
    public function setBillingPeriod($billingPeriod);

    /**
     * Get billing frequency
     *
     * @return int
     */
    public function getBillingFrequency();

    /**
     * Set billing frequency
     *
     * @param int $billingFrequency
     * @return $this
     */
    public function setBillingFrequency($billingFrequency);

    /**
     * Get total billing cycles
     *
     * @return int
     */
    public function getTotalBillingCycles();

    /**
     * Set total billing cycles
     *
     * @param int $totalBillingCycles
     * @return $this
     */
    public function setTotalBillingCycles($totalBillingCycles);

    /**
     * Get is initial fee enabled
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsInitialFeeEnabled();

    /**
     * Set is initial fee enabled
     *
     * @param bool $isInitialFeeEnabled
     * @return $this
     */
    public function setIsInitialFeeEnabled($isInitialFeeEnabled);

    /**
     * Get is trial period enabled
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsTrialPeriodEnabled();

    /**
     * Set is trial period enabled
     *
     * @param bool $isTrialPeriodEnabled
     * @return $this
     */
    public function setIsTrialPeriodEnabled($isTrialPeriodEnabled);

    /**
     * Get trial total billing cycles
     *
     * @return int
     */
    public function getTrialTotalBillingCycles();

    /**
     * Set trial total billing cycles
     *
     * @param int $trialTotalBillingCycles
     * @return $this
     */
    public function setTrialTotalBillingCycles($trialTotalBillingCycles);

    /**
     * Get start date
     *
     * @return string
     */
    public function getStartDate();

    /**
     * Set start date
     *
     * @param string $startDate
     * @return $this
     */
    public function setStartDate($startDate);

    /**
     * Check if profile cart contains only virtual items
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsCartVirtual();

    /**
     * Set virtual flag
     *
     * @param bool $isCartVirtual
     * @return $this
     */
    public function setIsCartVirtual($isCartVirtual);

    /**
     * Get profile items
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileItemInterface[]
     */
    public function getItems();

    /**
     * Set profile items
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileItemInterface[] $items
     * @return $this
     */
    public function setItems($items);

    /**
     * Get inner profile items (including non visible)
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileItemInterface[]
     */
    public function getInnerItems();

    /**
     * Set inner profile items
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileItemInterface[] $innerItems
     * @return $this
     */
    public function setInnerItems($innerItems);

    /**
     * Get profile addresses
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileAddressInterface[]
     */
    public function getAddresses();

    /**
     * Set profile addresses
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileAddressInterface[] $addresses
     * @return $this
     */
    public function setAddresses($addresses);

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get customer email
     *
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer email
     *
     * @param string $customerEmail
     * @return $this
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get customer group ID
     *
     * @return int
     */
    public function getCustomerGroupId();

    /**
     * Set customer group ID
     *
     * @param int $customerGroupId
     * @return $this
     */
    public function setCustomerGroupId($customerGroupId);

    /**
     * Get customer full name
     *
     * @return string
     */
    public function getCustomerFullname();

    /**
     * Set customer full name
     *
     * @param string $customerFullName
     * @return $this
     */
    public function setCustomerFullname($customerFullName);

    /**
     * Get customer prefix
     *
     * @return string|null
     */
    public function getCustomerPrefix();

    /**
     * Set customer prefix
     *
     * @param string $customerPrefix
     * @return $this
     */
    public function setCustomerPrefix($customerPrefix);

    /**
     * Get customer first name
     *
     * @return string|null
     */
    public function getCustomerFirstname();

    /**
     * Set customer first name
     *
     * @param string $firstname
     * @return $this
     */
    public function setCustomerFirstname($firstname);

    /**
     * Get customer middle name
     *
     * @return string|null
     */
    public function getCustomerMiddlename();

    /**
     * Set customer middle name
     *
     * @param string $middlename
     * @return $this
     */
    public function setCustomerMiddlename($middlename);

    /**
     * Get customer last name
     *
     * @return string|null
     */
    public function getCustomerLastname();

    /**
     * Set customer last name
     *
     * @param string $lastname
     * @return $this
     */
    public function setCustomerLastname($lastname);

    /**
     * Get customer suffix
     *
     * @return string|null
     */
    public function getCustomerSuffix();

    /**
     * Set customer suffix
     *
     * @param string $customerSuffix
     * @return $this
     */
    public function setCustomerSuffix($customerSuffix);

    /**
     * Get customer dob
     *
     * @return string|null
     */
    public function getCustomerDob();

    /**
     * Set customer dob
     *
     * @param string $customerDob
     * @return $this
     */
    public function setCustomerDob($customerDob);

    /**
     * Checks if customer is guest
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getCustomerIsGuest();

    /**
     * Set if customer is guest
     *
     * @param bool $customerIsGuest
     * @return $this
     */
    public function setCustomerIsGuest($customerIsGuest);

    /**
     * Get shipping method
     *
     * @return string
     */
    public function getShippingMethod();

    /**
     * Set shipping method
     *
     * @param string $shippingMethod
     * @return $this
     */
    public function setShippingMethod($shippingMethod);

    /**
     * Get shipping description
     *
     * @return string
     */
    public function getShippingDescription();

    /**
     * Set shipping description
     *
     * @param string $shippingDescription
     * @return $this
     */
    public function setShippingDescription($shippingDescription);

    /**
     * Get global currency code
     *
     * @return string
     */
    public function getGlobalCurrencyCode();

    /**
     * Set global currency code
     *
     * @param string $globalCurrencyCode
     * @return $this
     */
    public function setGlobalCurrencyCode($globalCurrencyCode);

    /**
     * Get base currency code
     *
     * @return string
     */
    public function getBaseCurrencyCode();

    /**
     * Set base currency code
     *
     * @param string $baseCurrencyCode
     * @return $this
     */
    public function setBaseCurrencyCode($baseCurrencyCode);

    /**
     * Get profile currency code
     *
     * @return string
     */
    public function getProfileCurrencyCode();

    /**
     * Set profile currency code
     *
     * @param string $profileCurrencyCode
     * @return $this
     */
    public function setProfileCurrencyCode($profileCurrencyCode);

    /**
     * Get base to global rate
     *
     * @return float
     */
    public function getBaseToGlobalRate();

    /**
     * Set base to global rate
     *
     * @param float $baseToGlobalRate
     * @return $this
     */
    public function setBaseToGlobalRate($baseToGlobalRate);

    /**
     * Get base to profile rate
     *
     * @return float
     */
    public function getBaseToProfileRate();

    /**
     * Set base to profile rate
     *
     * @param float $baseToProfileRate
     * @return $this
     */
    public function setBaseToProfileRate($baseToProfileRate);

    /**
     * Get grand total in cart currency
     *
     * @return float|null
     */
    public function getGrandTotal();

    /**
     * Set grand total in cart currency
     *
     * @param float $grandTotal
     * @return $this
     */
    public function setGrandTotal($grandTotal);

    /**
     * Get grand total in base currency
     *
     * @return float|null
     */
    public function getBaseGrandTotal();

    /**
     * Set grand total in base currency
     *
     * @param float $baseGrandTotal
     * @return $this
     */
    public function setBaseGrandTotal($baseGrandTotal);

    /**
     * Get subtotal in cart currency
     *
     * @return float|null
     */
    public function getSubtotal();

    /**
     * Set subtotal in cart currency
     *
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal($subtotal);

    /**
     * Get subtotal in base currency
     *
     * @return float|null
     */
    public function getBaseSubtotal();

    /**
     * Set subtotal in base currency
     *
     * @param float $baseSubtotal
     * @return $this
     */
    public function setBaseSubtotal($baseSubtotal);

    /**
     * Get shipping amount in cart currency
     *
     * @return float|null
     */
    public function getShippingAmount();

    /**
     * Set shipping amount in cart currency
     *
     * @param float $shippingAmount
     * @return $this
     */
    public function setShippingAmount($shippingAmount);

    /**
     * Get shipping amount in base currency
     *
     * @return float|null
     */
    public function getBaseShippingAmount();

    /**
     * Set shipping amount in base currency
     *
     * @param float $baseShippingAmount
     * @return $this
     */
    public function setBaseShippingAmount($baseShippingAmount);

    /**
     * Get tax amount in cart currency
     *
     * @return float|null
     */
    public function getTaxAmount();

    /**
     * Set tax amount in cart currency
     *
     * @param float $taxAmount
     * @return $this
     */
    public function setTaxAmount($taxAmount);

    /**
     * Get tax amount in base currency
     *
     * @return float|null
     */
    public function getBaseTaxAmount();

    /**
     * Set tax amount in base currency
     *
     * @param float $baseTaxAmount
     * @return $this
     */
    public function setBaseTaxAmount($baseTaxAmount);

    /**
     * Get trial subtotal
     *
     * @return float
     */
    public function getTrialSubtotal();

    /**
     * Set trial subtotal
     *
     * @param float $trialSubtotal
     * @return $this
     */
    public function setTrialSubtotal($trialSubtotal);

    /**
     * Get trial subtotal in base currency
     *
     * @return float
     */
    public function getBaseTrialSubtotal();

    /**
     * Set trial subtotal in base currency
     *
     * @param float $baseTrialSubtotal
     * @return $this
     */
    public function setBaseTrialSubtotal($baseTrialSubtotal);

    /**
     * Get trial tax amount
     *
     * @return float
     */
    public function getTrialTaxAmount();

    /**
     * Set trial tax amount
     *
     * @param float $trialTaxAmount
     * @return $this
     */
    public function setTrialTaxAmount($trialTaxAmount);

    /**
     * Get trial tax amount in base currency
     *
     * @return float
     */
    public function getBaseTrialTaxAmount();

    /**
     * Set trial tax amount in base currency
     *
     * @param float $baseTrialTaxAmount
     * @return $this
     */
    public function setBaseTrialTaxAmount($baseTrialTaxAmount);

    /**
     * Get initial fee amount
     *
     * @return float
     */
    public function getInitialFee();

    /**
     * Set initial fee amount
     *
     * @param float $initialFee
     * @return $this
     */
    public function setInitialFee($initialFee);

    /**
     * Get initial fee amount in base currency
     *
     * @return float
     */
    public function getBaseInitialFee();

    /**
     * Set initial fee amount in base currency
     *
     * @param float $baseInitialFee
     * @return $this
     */
    public function setBaseInitialFee($baseInitialFee);

    /**
     * Get remote IP address
     *
     * @return string
     */
    public function getRemoteIp();

    /**
     * Set remote IP address
     *
     * @param string $remoteIp
     * @return $this
     */
    public function setRemoteIp($remoteIp);

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Aheadworks\Sarp\Api\Data\ProfileExtensionInterface $extensionAttributes);
}
