<?php
namespace Aheadworks\Sarp\Cron;

use Aheadworks\Sarp\Model\SubscriptionEngine\Core\PaymentEngine;

/**
 * Class ProcessPendingPayments
 * @package Aheadworks\Sarp\Cron
 */
class ProcessPendingPayments
{
    /**
     * @var PaymentEngine
     */
    private $paymentEngine;

    /**
     * @param PaymentEngine $paymentEngine
     */
    public function __construct(PaymentEngine $paymentEngine)
    {
        $this->paymentEngine = $paymentEngine;
    }

    /**
     * Perform processing of pending payments
     *
     * @return void
     */
    public function execute()
    {
        $this->paymentEngine->payScheduledForToday();
        $this->paymentEngine->payReattemptsForToday();
    }
}
