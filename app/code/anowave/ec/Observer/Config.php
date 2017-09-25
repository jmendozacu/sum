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

namespace Anowave\Ec\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class Config implements ObserverInterface
{
	/**
	 * @var \Anowave\Ec\Helper\Data
	 */
	protected $_helper 			= null;
	
	/**
	 * @var \Magento\Framework\Message\ManagerInterface
	 */
	protected $_messageManager 	= null;
	
	/**
	 * API 
	 * 
	 * @var \Anowave\Ec\Model\Api
	 */
	protected $api = null;
	
	/**
	 * Constructor 
	 * 
	 * @param \Anowave\Ec\Helper\Data $helper
	 * @param \Magento\Framework\Message\ManagerInterface $messageManager
	 * @param \Anowave\Ec\Model\Api $api
	 */
	public function __construct
	(
		\Anowave\Ec\Helper\Data $helper,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Anowave\Ec\Model\Api $api
	)
	{
		$this->_helper 			= $helper;
		$this->_messageManager 	= $messageManager;
		$this->api				= $api;
	}
	/**
	 * Add order information into GA block to render on checkout success pages
	 *
	 * @param EventObserver $observer
	 * @return void
	 */
	public function execute(EventObserver $observer)
	{
		$this->_helper->notify($this->_messageManager);
		
		if (isset($_POST['args']) && $this->validate($_POST['groups']['api']['fields']))
		{
			/**
			 * Operation log
			*/
			$log = [];
			
			foreach (@$_POST['args'] as $entry)
			{
				$log = array_merge($log, $this->getApi()->create($entry));
			}
			
			if (!$log && isset($_POST['args']))
			{
				$log[] = 'Container configured succesfully. Please go to Google Tag Manager to preview newly created tags, variables and triggers.';
			}
			
			if ($log)
			{
				$this->_messageManager->addNotice(nl2br(join(PHP_EOL, $log)));
			}
		}
		
		if ('' !== (string) $this->_helper->getConfig('ec/general/code'))
		{
			$this->_messageManager->addError('It seems you are using older version of GTM snippet. Please update using the splitted version provided by Google Tag Manager otherwise tracking may not work.');
		}

		return true;
	}
	
	protected function getApi()
	{	
		return $this->api;
	}
	
	protected function validate(array $data = [])
	{
		$errors = [];

		if ('' === $data['google_gtm_ua']['value'])
		{
			$errors[] = __('Please provide valid Universal Analytics Tracking ID');
		}
		
		if ('' == $data['google_gtm_account_id']['value'])
		{
			$errors[] = __('Please provide valid GTM Account ID');
		}
		
		if ('' == $data['google_gtm_container']['value'])
		{
			$errors[] = __('Please provide valid GTM Container ID');
		}
		else 
		{
			if (!is_numeric($data['google_gtm_container']['value']))
			{
				$errors[] = __('GTM Container ID is invalid. Expected numeric value.');
			}
		}
		
		if (!$errors)
		{
			return true;
		}
		
		foreach ($errors as $error) 
		{
			$this->_messageManager->addError($error);
		}
		
		return false;
	}
}
