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
 
/**
 * Autoloader
 * 
 * @author Anowave
 */
 
if (!function_exists('google_loader'))
{
	function google_loader($class)
	{
		if (false === strpos($class, 'Google_'))
		{
			return;
		}
		
		$class = join(DIRECTORY_SEPARATOR, explode('_', $class));
		
		/**
		 * Construct pathname
		 *
		 * @var string
		*/
		$pathname = __DIR__ . "/vendor/$class.php";
		
		if (file_exists($pathname))
		{
			require_once($pathname);
		}
	}

	spl_autoload_register('google_loader');
}

\Magento\Framework\Component\ComponentRegistrar::register(\Magento\Framework\Component\ComponentRegistrar::MODULE,'Anowave_Ec',__DIR__);