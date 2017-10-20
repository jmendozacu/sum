<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Config\Source;

use Magento\Payment\Model\Source\Cctype as PaymentCctype;

/**
 * Class Cctype
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Stripe\Config\Source
 */
class Cctype extends PaymentCctype
{
    /**
     * {@inheritdoc}
     */
    public function getAllowedTypes()
    {
        return ['VI', 'MC', 'AE', 'DI', 'JCB', 'DN'];
    }
}
