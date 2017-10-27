<?php

namespace Imindstudio\Autoship\Block;

class Orders extends \Magento\Sales\Block\Order\History
{
    private $orderCollectionFactory;

    protected $_searchCriteria;
    protected $_orderRepository;
    protected $_collectionFactory;
    protected $_profileCollectionFactory;
    protected $_profileRepositoryInterface;
    protected $_profileOrderRepositoryInterface;

    public function __construct(
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteria,
        \Aheadworks\Sarp\Api\ProfileRepositoryInterface $profileRepositoryInterface,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Aheadworks\Sarp\Api\ProfileOrderRepositoryInterface $profileOrderRepositoryInterface,
        \Aheadworks\Sarp\Model\ResourceModel\Profile\Order\CollectionFactory $profileCollectionFactory,
        array $data = []
    ) {
        $this->_searchCriteria                  = $searchCriteria;
        $this->_orderRepository                 = $orderRepository;
        $this->_collectionFactory               = $collectionFactory;
        $this->_profileCollectionFactory        = $profileCollectionFactory;
        $this->_profileRepositoryInterface      = $profileRepositoryInterface;
        $this->_profileOrderRepositoryInterface = $profileOrderRepositoryInterface;

        parent::__construct(
            $context,
            $orderCollectionFactory,
            $customerSession,
            $orderConfig,
            $data
        );
    }

    public function setOrders($collection)
    {
        $this->orders = $collection;
    }

    public function getOrders()
    {
        if ($this->orders) {
            $profileCollection = $this->_profileCollectionFactory->create();

            $profileCollection->setCurPage(2);
            $profileCollection->setPageSize(1);

            foreach ($profileCollection as $profile) {
                var_dump($profile->get());
            }

            return $this->orders;
        } else {
            return [];
        }
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('orders.pager');
    }

    public function getOriginOrders()
    {
        $orders = $this->_getNewCollection();
        $profileOrders = $this->_getProfileOrders();

        foreach ($profileOrders as $profileOrder) {
            $orders->addItem($this->_orderRepository->get($profileOrder->getOrderId()));
        };

        return $orders;
    }

    public function getProfileOrders()
    {
        $orders = $this->_getNewCollection();
        $profileOrders = $this->_getProfileOrders();

        foreach ($profileOrders as $profileOrder) {
            $order = $this->_orderRepository->get($profileOrder->getOrderId());
            $profile = $this->_profileRepositoryInterface->get($profileOrder->getProfileId());
            $previousDate = $profile->getLastOrderDate();
            $datePeriod = $profile->getBillingPeriod();
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

            $order->setNextShipDate($nextDate);
            $order->setFrequency($profile->getBillingPeriod());
            $order->setProfileId($profile->getProfileId());
            $orders->addItem($order);
        };

        return $orders;
    }

    protected function _getNewCollection()
    {
        $collection = $this->_collectionFactory->create();

        $collection->setCurPage(1);
        $collection->setPageSize(1);

        $collection->load();

        return $collection;
    }

    protected function _getProfileOrders()
    {
        if (!($customerId = $this->_customerSession->getCustomerId())) {
            return [];
        } else {
            return $this->_profileOrderRepositoryInterface->getList(
                $this->_searchCriteria->addFilter('customer_id', $customerId)->create()
            )->getItems();
        }
    }
}
