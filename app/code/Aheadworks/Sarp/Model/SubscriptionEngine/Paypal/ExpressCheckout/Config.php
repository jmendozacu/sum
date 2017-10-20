<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\ExpressCheckout;

use Aheadworks\Sarp\Model\Checkout\ConfigProviderInterface;
use Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Url;

/**
 * Class Config
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\Paypal
 */
class Config implements ConfigProviderInterface
{
    /**
     * @var Url
     */
    private $url;

    /**
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return [
            'payment' => [
                'paypalExpress' => [
                    'redirectUrl' => $this->url->getCheckoutRedirectUrl(),
                    'paymentAcceptanceMarkHref' => $this->url->getPaymentMarkWhatIsPayPalUrl(),
                    'paymentAcceptanceMarkSrc' => $this->url->getPaymentMarkImageUrl()
                ]
            ]
        ];
    }
}
