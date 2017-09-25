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

define(['jquery','priceBox','underscore','mage/template', 'Magento_Catalog/js/price-utils'], function ($, priceBox, us, mageTemplate, utils) 
{
    'use strict';
    
    priceBox.prototype.reloadPrice = function reDrawPrices() 
    {
        var priceFormat = (this.options.priceConfig && this.options.priceConfig.priceFormat) || {},priceTemplate = mageTemplate(this.options.priceTemplate);

	    us.each(this.cache.displayPrices, function (price, priceCode) 
		{
	        price.final = us.reduce(price.adjustments, function(memo, amount) { return memo + amount }, price.amount);
	
	        price.formatted = utils.formatPrice(price.final, priceFormat);
	
	        $('[data-price-type="' + priceCode + '"]', this.element).html(priceTemplate({data: price}));
	        
	        /**
	         * Set data-price attribute
	         */
	        $('[id=product-addtocart-button]').attr('data-price',price.final).data('price',price.final);
	        
	    }, this);
	}
    return priceBox;
});