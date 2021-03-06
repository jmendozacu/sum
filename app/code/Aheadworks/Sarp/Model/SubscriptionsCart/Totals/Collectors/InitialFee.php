<?php
namespace Aheadworks\Sarp\Model\SubscriptionsCart\Totals\Collectors;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartTotalsInterface;
use Aheadworks\Sarp\Api\SubscriptionPlanRepositoryInterface;
use Aheadworks\Sarp\Model\SubscriptionsCart\Totals\CollectorInterface;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address\ItemsRegistry;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class InitialFee
 * @package Aheadworks\Sarp\Model\SubscriptionsCart\Totals\Collectors
 */
class InitialFee implements CollectorInterface
{
    /**
     * @var ItemsRegistry
     */
    private $addressItemsRegistry;

    /**
     * @var SubscriptionPlanRepositoryInterface
     */
    private $planRepository;

    /**
     * @var SubscriptionPriceCalculator
     */
    private $priceCalculator;

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @param ItemsRegistry $addressItemsRegistry
     * @param SubscriptionPlanRepositoryInterface $planRepository
     * @param SubscriptionPriceCalculator $priceCalculator
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        ItemsRegistry $addressItemsRegistry,
        SubscriptionPlanRepositoryInterface $planRepository,
        SubscriptionPriceCalculator $priceCalculator,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->addressItemsRegistry = $addressItemsRegistry;
        $this->planRepository = $planRepository;
        $this->priceCalculator = $priceCalculator;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(
        SubscriptionsCartInterface $cart,
        SubscriptionsCartAddressInterface $address,
        SubscriptionsCartTotalsInterface $totals
    ) {
        foreach ($this->addressItemsRegistry->retrieveInner($address, $cart) as $item) {
            if (!$item->getIsDeleted()) {
                $baseInitialFee = 0;

                if ($cart->getSubscriptionPlanId()) {
                    $plan = $this->planRepository->get($cart->getSubscriptionPlanId());
                    if ($plan->getIsInitialFeeEnabled()) {
                        $baseInitialFee = $this->priceCalculator->getBaseInitialFee(
                            $item,
                            $this->addressItemsRegistry->retrieveChild($address, $cart, $item->getItemId())
                        );
                    }
                }

                $initialFee = $this->priceCurrency->convert($baseInitialFee);
                $item
                    ->setBaseInitialFee($baseInitialFee)
                    ->setInitialFee($initialFee);
            }
        }
    }
}
