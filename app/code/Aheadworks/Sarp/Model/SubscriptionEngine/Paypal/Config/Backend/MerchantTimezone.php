<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Config\Backend;

use Magento\Framework\App\Config\Value;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class MerchantTimezone
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Config\Backend
 */
class MerchantTimezone extends Value
{
    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        if ($this->getValue()
            && !in_array($this->getValue(), \DateTimeZone::listIdentifiers(\DateTimeZone::ALL))
        ) {
            throw new LocalizedException(__('Please correct the timezone.'));
        }
        return $this;
    }
}
