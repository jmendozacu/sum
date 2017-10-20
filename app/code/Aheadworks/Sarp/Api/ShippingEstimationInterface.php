<?php
namespace Aheadworks\Sarp\Api;

/**
 * Interface ShippingEstimationInterface
 * @package Aheadworks\Sarp\Api
 */
interface ShippingEstimationInterface
{
    /**
     * Estimate shipping
     *
     * @param int $cartId
     * @param \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface $shippingAddress
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[]
     */
    public function estimate(
        $cartId,
        \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface $shippingAddress
    );

    /**
     * Estimate shipping by customer address Id
     *
     * @param int $cartId
     * @param int $customerAddressId
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[]
     */
    public function estimateByCustomerAddressId($cartId, $customerAddressId);
}
