<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Core\Subscription;

/**
 * Class SecureDataFilter
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Core\Subscription
 */
class SecureDataFilter
{
    /**
     * @var array
     */
    private $privateData = [];

    /**
     * @param array $privateData
     */
    public function __construct(array $privateData)
    {
        $this->privateData = $privateData;
    }

    /**
     * Remove possible private data from payment data
     *
     * @param array $paymentData
     * @param string $paymentMethodCode
     * @return array
     */
    public function filter(array $paymentData, $paymentMethodCode)
    {
        $keysToRemove = isset($this->privateData[$paymentMethodCode])
            ? $this->privateData[$paymentMethodCode]
            : [];
        foreach ($keysToRemove as $key) {
            unset($paymentData[$key]);
        }
        return $paymentData;
    }
}
