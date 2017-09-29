<?php

namespace Imindstudio\Autoship\Block;

class Rewards extends \Magento\Framework\View\Element\Template
{
    private $_signUpPoints;
    private $_redeemedPoints;
    private $_customerOrderPoints;
    private $_customerReviewPoints;
    private $_referredCustomerPoints;

    protected $_order;
    protected $_helper;
    protected $_session;
    protected $_listing;

    public function __construct(
        \Imindstudio\Autoship\Model\Order $order,
        \Mirasvit\Rewards\Helper\Balance $helper,
        \Magento\Customer\Model\Session $session,
        \Mirasvit\Rewards\Block\Account\Listing $listing,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        parent::__construct($context);

        $this->_signUpPoints = 0;
        $this->_redeemedPoints = 0;
        $this->_customerOrderPoints = 0;
        $this->_customerReviewPoints = 0;
        $this->_referredCustomerPoints = 0;

        $this->_order = $order;
        $this->_helper = $helper;
        $this->_listing = $listing;
        $this->_session = $session;

        $this->_init();
    }

    public function getSignUpPoints()
    {
        return $this->_signUpPoints;
    }

    public function getRedeemedPoints()
    {
        return $this->_redeemedPoints;
    }

    public function getCustomerOrderPoints()
    {
        return $this->_customerOrderPoints;
    }

    public function getCustomerReviewPoints()
    {
        return $this->_customerReviewPoints;
    }

    public function getReferredCustomerPoints()
    {
        return $this->_referredCustomerPoints;
    }

    public function isLoggedIn()
    {
        return $this->_session->isLoggedIn();
    }

    public function getCompletedOrdersCount()
    {
        return $this->_order->getOrdersCount();
    }

    public function getBalancePoints()
    {
        return $this->_helper->getBalancePoints($this->_session->getCustomer());
    }

    private function _init()
    {
        $collection = $this->_listing->getTransactionCollection();

        foreach ($collection as $transaction) {
            $amount = (int)$transaction->getAmount();

            if ($amount > 0) {
                switch(explode('-', $transaction->getCode())[0])
                {
                    case 'review':
                        $this->_customerReviewPoints += $amount;
                        break;
                    case 'customer_order':
                        $this->_customerOrderPoints += $amount;
                        break;
                    case 'referred_customer_signup':
                        $this->_referredCustomerPoints += $amount;
                        break;
                    case 'signup':
                        $this->_signUpPoints = $amount;
                        break;
                    default:
                        break;
                }
            } else {
                $this->_redeemedPoints += $amount;
            }
        }
    }
}
