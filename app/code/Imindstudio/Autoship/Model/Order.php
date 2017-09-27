<?php

namespace Imindstudio\Autoship\Model;

class Order extends \Magento\Sales\Block\Order\History
{
    protected $_orderCollectionFactory;

    public function getOrdersCount()
    {
        if (!($customerId = $this->_customerSession->getCustomerId())) {
            return false;
        }

        if (!$this->orders) {
            $this->orders = $this->getOrderCollectionFactory()->create($customerId)
            ->addFieldToFilter(
                'status', ['eq' => ['complete']]
            )->getSize();
        }

        return $this->orders;
    }

    private function getOrderCollectionFactory()
    {
        if ($this->_orderCollectionFactory === null) {
            $this->_orderCollectionFactory = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface::class
            );
        }

        return $this->_orderCollectionFactory;
    }
}
