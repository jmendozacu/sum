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


namespace Anowave\Ec\Helper;

use Anowave\Package\Helper\Package;

class Constants extends \Anowave\Package\Helper\Package
{
	/**
	 * Checkout shipping step 
	 * 
	 * @var integer
	 */
	const CHECKOUT_STEP_SHIPPING = 1;
	
	/**
	 * Checkout payment step 
	 * 
	 * @var integer
	 */
	const CHECKOUT_STEP_PAYMENT  = 2;
	
	/*
	 * Related products list name/category
	 */
	const LIST_RELATED 	= 'Related products';
	
	/*
	 * Cross sells list name/category
	 */
	const LIST_CROSS_SELL = 'Cross Sells';
	
	/*
	 * Upsells products list name/category
	 */
	const LIST_UP_SELL 	= 'Up Sells';
	
	/**
	 * Impression item selector
	 * 
	 * @var string
	 */
	const XPATH_LIST_SELECTOR = '//ol[contains(@class, "products")]/li';
	
	/**
	 * Impression item click selector 
	 * 
	 * @var string
	 */
	const XPATH_LIST_CLICK_SELECTOR = 'div/a';
	
	/**
	 * Add to cart button selector
	 * 
	 * @var string
	 */
	const XPATH_CART_SELECTOR = '//button[@id="product-addtocart-button"]';
	
	/**
	 * Add to cart button from categories selector
	 * 
	 * @var string
	 */
	const XPATH_CART_CATEGORY_SELECTOR 	= 'div/div/div/div/div/form/button[contains(@class,"tocart")]';
	
	/**
	 * Remove from cart selector
	 * 
	 * @var string
	 */
	const XPATH_CART_DELETE_SELECTOR = '//a[contains(@class,"action-delete")]|//a[contains(@class,"remove")]';
}