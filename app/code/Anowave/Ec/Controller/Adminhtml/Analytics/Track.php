<?php
/**
 * Anowave Magento 2 Google Tag Manager Enhanced Ecommerce (UA) Tracking
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Anowave license that is
 * available through the world-wide-web at this URL:
 * http://www.anowave.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category 	Anowave
 * @package 	Anowave_Ec
 * @copyright 	Copyright (c) 2017 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */

namespace Anowave\Ec\Controller\Adminhtml\Analytics;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Api\OrderManagementInterface;

class Track extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
	/**
	 * @var OrderManagementInterface
	 */
	protected $orderManagement;
	
	/**
	 * @var \Anowave\Ec\Model\Api\Measurement\Protocol
	 */
	protected $protocol;
	
	/**
	 * Constructor 
	 * 
	 * @param Context $context
	 * @param Filter $filter
	 * @param CollectionFactory $collectionFactory
	 * @param OrderManagementInterface $orderManagement
	 */
	public function __construct
	(
		Context $context,
		Filter $filter,
		CollectionFactory $collectionFactory,
		OrderManagementInterface $orderManagement,
		\Anowave\Ec\Model\Api\Measurement\Protocol $protocol
	) 
	{
		parent::__construct($context, $filter);
		
		/**
		 * Set collection factory 
		 * 
		 * @var CollectionFactory
		 */
		$this->collectionFactory = $collectionFactory;
		
		/**
		 * Set order management 
		 * 
		 * @var OrderManagementInterface
		 */
		$this->orderManagement = $orderManagement;
		
		/**
		 * Set Measurement Protocol
		 */
		$this->protocol = $protocol;
	}
	
	protected function massAction(AbstractCollection $collection) 
	{
        $ids = $collection->getAllIds();
        
        /**
         * @todo: Loop orders and send to Google Analytics
         */
        
        $this->messageManager->addNotice('This function is not available yet.');
        
        $resultRedirect = $this->resultRedirectFactory->create();
        
        $resultRedirect->setPath('sales/order/index');
        
        return $resultRedirect;
    }

    protected function _isAllowed() 
    {
        return true;
    }
}