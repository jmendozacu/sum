<?php
namespace Aheadworks\Sarp\Api;

/**
 * Payment method management interface
 */
interface PaymentMethodManagementInterface
{
    /**
     * Get available payment methods for specified cart ID
     *
     * @param int $cartId
     * @return \Aheadworks\Sarp\Api\Data\PaymentMethodInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getList($cartId);
}
