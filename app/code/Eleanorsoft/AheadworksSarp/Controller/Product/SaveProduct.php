<?php

namespace Eleanorsoft\AheadworksSarp\Controller\Product;
use Aheadworks\Sarp\Controller\Product\Subscribe;
use Aheadworks\Sarp\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartItemInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartItemInterfaceFactory;
use Aheadworks\Sarp\Api\SubscriptionsCartManagementInterface;
use Aheadworks\Sarp\Model\SubscriptionsCart\Persistor as CartPersistor;
use Eleanorsoft\AheadworksSarp\Helper\Data;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class SaveProduct
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class SaveProduct extends Subscribe
{

    /**
     * @var SubscriptionsCartManagementInterface
     */
    protected $cartManagement;

    /**
     * @var CartPersistor
     */
    protected $cartPersistor;

    /**
     * @var SubscriptionsCartItemInterfaceFactory
     */
    protected $itemFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Session
     */
    protected $session;


    /**
     * SaveProduct constructor.
     * @param Context $context
     * @param SubscriptionsCartManagementInterface $cartManagement
     * @param CartPersistor $cartPersistor
     * @param SubscriptionsCartItemInterfaceFactory $itemFactory
     * @param Data $helper
     * @param Session $session
     */
    public function __construct
    (
        Context $context,
        SubscriptionsCartManagementInterface $cartManagement,
        CartPersistor $cartPersistor,
        SubscriptionsCartItemInterfaceFactory $itemFactory,
        Data $helper,
        Session $session
    )
    {
        parent::__construct($context, $cartManagement, $cartPersistor, $itemFactory);
        $this->cartManagement = $cartManagement;
        $this->cartPersistor = $cartPersistor;
        $this->itemFactory = $itemFactory;
        $this->helper = $helper;
        $this->session = $session;
    }


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $response_json = file_get_contents("php://input");
        $params = json_decode($response_json, true);
        $profileId = $this->getRequest()->getParam('profile_id');
        $repeatId =  $repeat = $this->getRequest()->getParam('es_change_repeat_select');


        if ($params && $profileId) {
            /** @var Json $resultJson */
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            $profile = $this->helper->getProfile($profileId);

            try {
                $cart = $this->cartPersistor->getSubscriptionCart();
                if (!$cart->getCartId()) {
                    $cart->setIsActive(true);
                }
                $planId = ($repeatId) ? $repeatId : $profile->getSubscriptionPlanId();

                $date = $this->helper->getStartDate($profile);
                $cart->setStartDate($date);

                foreach ($params as $param) {

                    if ($param['qty'] == 0) {
                        continue;
                    }
                    /** @var SubscriptionsCartItemInterface $cartItem */
                    $cartItem = $this->itemFactory->create();

                    $cartItem
                        ->setProductId($param['product_id'])
                        ->setBuyRequest($this->getBuyRequestSerialized($param));

                    if (isset($param['qty'])) {
                        $cartItem->setQty($param['qty']);
                    }

                    $this->cartManagement->add($cart, $cartItem);
                    $cartId = $cart->getCartId();
                }

                $this->messageManager->addSuccessMessage(
                    __('You added to subscription cart.')
                );

                $this->cartManagement->selectSubscriptionPlan($cartId, $planId);

                $this->session->setProfileId($profileId);
                $this->session->setSuccessCartId($cartId);

                return $resultJson->setData(
                    ['redirectUrl' => $this->_url->getUrl('aw_sarp/checkout/index')]
                );
            } catch (LocalizedException $e) {
                $messages = array_unique(explode('\n', $e->getMessage()));
                foreach ($messages as $message) {
                    $this->messageManager->addErrorMessage($message);
                }
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t add this item to subscription cart right now.')
                );
            }

            return $resultJson->setData([]);
        }
    }

    /**
     * Get buy request serialized
     *
     * @param array $params
     * @return string
     */
    private function getBuyRequestSerialized($params)
    {
        if (isset($params['form_key'])) {
            unset($params['form_key']);
        }
        return serialize($params);
    }
}