<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Core\Payment;

use Aheadworks\Sarp\Api\Data\ProfileInterface;
use Aheadworks\Sarp\Api\Data\ProfilePaymentInfoInterface;

/**
 * Interface ActionInterface
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Core\Payment
 */
interface ActionInterface
{
    /**
     * Perform pay action
     *
     * @param ProfileInterface $profile
     * @param ProfilePaymentInfoInterface $paymentInfo
     * @param array $additionalData
     * @return ActionResult
     */
    public function pay(
        ProfileInterface $profile,
        ProfilePaymentInfoInterface $paymentInfo,
        array $additionalData
    );
}
