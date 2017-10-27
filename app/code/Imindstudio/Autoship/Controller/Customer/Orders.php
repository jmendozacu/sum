<?php

namespace Imindstudio\Autoship\Controller\Customer;

class Orders extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $request = $this->getRequest();
        $layout = $this->_view->loadLayout();
        $ordersBlock = $layout->getLayout()->getBlock('orders');

        if ($request->getParam('type') == 'origin_order') {
            $collection = $ordersBlock->getOriginOrders();

            $ordersBlock->setTemplate('Magento_Sales::order/history.phtml');
        } else {
            $collection = $ordersBlock->getProfileOrders();
        }

        if ($collection) {
            $ordersBlock->setOrders($collection);

            $pager = $layout->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'orders.pager'
            )->setCollection($ordersBlock->getOrders());

            $ordersBlock->setChild('orders.pager', $pager);
        }

		$this->_view->renderLayout();
	}
}
