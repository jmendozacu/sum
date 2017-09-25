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


define(['Magento_Checkout/js/model/quote'],function(quote) 
{
    'use strict';
    
    return function (paymentMethod) 
    {
    	if ('undefined' !== typeof dataLayer && 'undefined' !== typeof data)
    	{
    		(function(dataLayer, $)
    		{
    			/**
        		 * Empty default payment method by default
        		 */
        		var method = '';
        		
        		if (paymentMethod && paymentMethod.hasOwnProperty('title'))
        		{
        			/**
        			 * Set payment method
        			 */
        			method = paymentMethod.title;
        		}
        		else 
        		{
        			/**
        			 * By default send payment method as code
        			 */
        			method = paymentMethod.method;
        			
        			/**
        			 * Try to map payment method to user-friendly text representation
        			 */
        			if (paymentMethod.hasOwnProperty('method'))
        			{
        				var label = $('label[for="' + paymentMethod.method + '"]');
        				
        				if (label.length && label.find('>span').length > 0)	
        				{
        					method = label.find('>span').text();
        				}
        			}
        			else 
        			{
        				console.log('Unable to determine payment method');
        			}
        			
        		}
        		
        		AEC.Checkout.stepOption(AEC.Const.CHECKOUT_STEP_PAYMENT, method);

    		})(dataLayer, jQuery);
    	}
    	
        quote.paymentMethod(paymentMethod);
    }
});