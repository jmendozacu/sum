<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model;

use Aheadworks\Sarp\Api\Data\PaymentMethodInterface;
use Aheadworks\Sarp\Api\Data\PaymentMethodInterfaceFactory;
use Aheadworks\Sarp\Api\PaymentMethodManagementInterface;
use Aheadworks\Sarp\Api\SubscriptionPlanRepositoryInterface;
use Aheadworks\Sarp\Api\SubscriptionsCartRepositoryInterface;
use Aheadworks\Sarp\Model\SubscriptionEngine\EngineMetadataPool;

/**
 * Class PaymentMethodManagement
 * @package Aheadworks\Sarp\Model
 */
class PaymentMethodManagement implements PaymentMethodManagementInterface
{
    /**
     * @var EngineMetadataPool
     */
    private $engineMetadataPool;

    /**
     * @var PaymentMethodInterfaceFactory
     */
    private $paymentMethodFactory;

    /**
     * @var SubscriptionPlanRepositoryInterface
     */
    private $planRepository;

    /**
     * @var SubscriptionsCartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @param EngineMetadataPool $engineMetadataPool
     * @param PaymentMethodInterfaceFactory $paymentMethodFactory
     * @param SubscriptionPlanRepositoryInterface $planRepository
     * @param SubscriptionsCartRepositoryInterface $cartRepository
     */
    public function __construct(
        EngineMetadataPool $engineMetadataPool,
        PaymentMethodInterfaceFactory $paymentMethodFactory,
        SubscriptionPlanRepositoryInterface $planRepository,
        SubscriptionsCartRepositoryInterface $cartRepository
    ) {
        $this->engineMetadataPool = $engineMetadataPool;
        $this->paymentMethodFactory = $paymentMethodFactory;
        $this->planRepository = $planRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getList($cartId)
    {
        $methodList = [];
        $cart = $this->cartRepository->get($cartId);
        $planId = $cart->getSubscriptionPlanId();
        if ($planId) {
            $plan = $this->planRepository->get($planId);
            $engineMetadata = $this->engineMetadataPool->getMetadata($plan->getEngineCode());
            /** @var PaymentMethodInterface $paymentMethod */
            $paymentMethod = $this->paymentMethodFactory->create();
            $paymentMethod
                ->setCode($engineMetadata->getCode())
                ->setTitle($engineMetadata->getLabel());
            $methodList[] = $paymentMethod;
        }
        return $methodList;
    }
}
