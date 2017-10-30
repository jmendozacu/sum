<?php

namespace Imindstudio\Autoship\Controller\Customer;

class Orders extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $this->_view->loadLayout();

        if ($this->getRequest()->getParam('type') != 'autoship') {
            $this->_view->getLayout()
                ->getBlock('page.main.title')
                ->setPageTitle(__('YOUR ORDER HISTORY'));
        }

		$this->_view->renderLayout();
	}
}
