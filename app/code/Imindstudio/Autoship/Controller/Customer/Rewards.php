<?php

namespace Imindstudio\Autoship\Controller\Customer;

class Rewards extends \Magento\Framework\App\Action\Action {
	
	public function execute() {
		
		$this->_view->loadLayout();
		$this->_view->renderLayout();
	}
	
}