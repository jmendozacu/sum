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

class Newsletter implements ObserverInterface
{
	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $session;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Customer\Model\Session $session
	 */
	public function __construct
	(
		\Magento\Customer\Model\Session $session
	)
	{
		$this->session = $session;	
	}
	
	/**
	 * Execute (non-PHPdoc)
	 * 
	 * @see \Magento\Framework\Event\ObserverInterface::execute()
	 */
	public function execute(EventObserver $observer)
	{
		$this->session->setNewsletterEvent(json_encode(
		[
			'event' 			=> 'newsletterSubmit',
			'eventCategory' 	=> __('Newsletter'),
			'eventAction' 		=> __('Submit'),
			'eventLabel' 		=> __('Subscribe'),
			'eventValue' 		=> 1
		]));
	}
}