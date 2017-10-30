<?php

namespace Imindstudio\Autoship\Block;

class Orders extends \Magento\Sales\Block\Order\History
{
    const PAGE_LIMIT = 10;

    protected $_request;
    protected $_orderCurrency;
    protected $_currencyFactory;
    protected $_collectionFactory;
    protected $_profileCollectionFactory;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Aheadworks\Sarp\Model\ResourceModel\Profile\Order\CollectionFactory $profileCollectionFactory,
        array $data = []
    ) {
        $this->orders                    = null;
        $this->_request                  = $request;
        $this->_currencyFactory          = $currencyFactory;
        $this->_collectionFactory        = $collectionFactory;
        $this->_profileCollectionFactory = $profileCollectionFactory;

        parent::__construct(
            $context,
            $orderCollectionFactory,
            $customerSession,
            $orderConfig,
            $data
        );
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('orders.pager');
    }

    public function getOrderCurrency($code)
    {
        if ($this->_orderCurrency === null) {
            $this->_orderCurrency = $this->_currencyFactory->create();
        }

        return $this->_orderCurrency->load($code);
    }

    public function formatPrice($currencyCode, $price, $addBrackets = false)
    {
        return $this->formatPricePrecision($currencyCode, $price, 2, $addBrackets);
    }

    public function getReorderUrl($order)
    {
        return $this->getUrl('sales/order/reorder', ['order_id' => $order->getEntityId()]);
    }

    public function formatPricePrecision($currencyCode, $price, $precision, $addBrackets = false)
    {
        return $this->getOrderCurrency($currencyCode)
            ->formatPrecision($price, $precision, [], true, $addBrackets);
    }

    public function getOrders()
    {
        if (!$this->orders) {
            $page = $this->_request->getParam('p');
            $profileCollection = $this->_profileCollectionFactory->create();

            $profileCollection->setPageSize(self::PAGE_LIMIT)->setCurPage($page ? $page : 1);
            $profileCollection->addFieldToSelect(['order_id', 'profile_id']);
            $profileCollection->getSelect()->join('sales_order',
                'sales_order.entity_id = main_table.order_id ',
                [
                    'status',
                    'entity_id',
                    'created_at',
                    'customer_id',
                    'increment_id',
                    'order_currency_code',
                    'shipping_address_id'
                ]
            );
            $profileCollection->getSelect()->join('sales_order_address',
                'sales_order_address.entity_id = sales_order.shipping_address_id ',
                ['lastname', 'firstname']
            );
            $profileCollection->addFieldToFilter(
                'sales_order.customer_id', $this->_customerSession->getCustomer()->getId()
            );

            if ($this->_request->getParam('type') == 'autoship') {
                $profileCollection->getSelect()->join('aw_sarp_profile',
                    'aw_sarp_profile.profile_id = main_table.profile_id ',
                    ['billing_period', 'last_order_date']
                );

                foreach ($profileCollection as $profile) {
                    $datePeriod = $profile->getBillingPeriod();
                    $previousDate = $profile->getLastOrderDate();
                    $datePeriodCount = intval($datePeriod);

                    if ($previousDate) {
                        $nextDate = date('Y-m-d',
                            strtotime(
                                $previousDate.' + '.($datePeriodCount ? $datePeriodCount : '1').' '.$datePeriod
                            )
                        );
                    } else {
                        $nextDate = null;
                    }

                    $profile->setNextShipDate($nextDate);
                    $profile->setFrequency($profile->getBillingPeriod());
                };
            } else {
                $this->setTemplate('Imindstudio_Autoship::history.phtml');
            }

            $this->orders = $profileCollection->load();
        }

        return $this->orders;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getOrders()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'autoship.orders.pager'
            )
                ->setLimit(self::PAGE_LIMIT)
                ->setCollection(
                    $this->getOrders()
                );

            $this->setChild('orders.pager', $pager);
        }
        return $this;
    }
}
