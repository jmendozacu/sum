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

namespace Anowave\Ec\Block;

class Result
{
	/**
	 * @var \Magento\Framework\Registry
	 */
	protected $_coreRegistry = null;
	/**
	 * @var \Anowave\Ec\Helper\Data
	 */
	protected $_helper = null;
	
	/**
	 * @var \Anowave\Ec\Helper\Dom
	 */
	protected $_helperDom = null;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\Registry
	 * @param \Anowave\Ec\Helper\Data $helper
	 * @param \Anowave\Ec\Helper\Dom $helperDom
	 */
	public function __construct
	(
		\Magento\Framework\Registry $registry,
		\Anowave\Ec\Helper\Data $helper,
		\Anowave\Ec\Helper\Dom $helperDom)
	{
		$this->_helper 		= $helper;
		$this->_helperDom 	= $helperDom;
		
		$this->_coreRegistry = $registry;
	}
	
	/**
	 * Augment search results block 
	 * 
	 * @param \Magento\CatalogSearch\Block\Result $block
	 * @param string $content
	 * @return string
	 */
	public function afterGetProductListHtml($block, $content)
	{
		/**
		 * Retrieve list of impression product(s)
		 * 
		 * @var array
		 */
		$products = [];
		
		foreach ($block->getListBlock()->getLoadedProductCollection() as $product)
		{
			$products[] = $product;
		}
		
		/**
		 * Append tracking
		 */
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

		$query = new \DOMXPath($dom);
		
		foreach ($query->query($this->_helper->getListSelector()) as $key => $element)
		{
			if (isset($products[$key]))
			{
				/**
				 * Add data-* attributes used for tracking dynamic values
				 */
				foreach ($query->query($this->_helper->getListClickSelector(), $element) as $a)
				{
					$click = $a->getAttribute('onclick');
						
					$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
					$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
					$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
					$a->setAttribute('data-category',   __('Search results'));
					$a->setAttribute('data-list',		__('Search results'));
					$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
					$a->setAttribute('data-quantity', 	1);
					$a->setAttribute('data-click',		$click);
					$a->setAttribute('data-store',		$this->_helper->getStoreName());
					$a->setAttribute('onclick',			'return AEC.click(this,dataLayer)');
				}
				
				/**
				 * Direct "Add to cart" from search results
				 */
				if ('' !== $selector = $this->_helper->getCartCategorySelector())
				{
					foreach (@$query->query($selector, $element) as $a)
					{
						$click = $a->getAttribute('onclick');
					
						$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
						$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
						$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
						$a->setAttribute('data-category',   __('Search results'));
						$a->setAttribute('data-list',		__('Search results'));
						$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
						$a->setAttribute('data-quantity', 	1);
						$a->setAttribute('data-click',		$click);
						$a->setAttribute('data-store',		$this->_helper->getStoreName());
						$a->setAttribute('onclick',			'return AEC.ajaxList(this,dataLayer)');
					}
				}
			}
		}
		
		return $this->_helperDom->getDOMContent($dom, $doc);
	}
	
	public function afterToHtml($block, $content)
	{
		return $content;
	}
}