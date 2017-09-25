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

use Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Boolean;

class Plugin
{
	/**
	 * Helper
	 *
	 * @var \Anowave\Ec\Helper\Data
	 */
	protected $_helper = null;
	
	/**
	 * Config
	 *
	 * @var \Magento\Framework\App\Config\ScopeConfigInterface
	 */
	protected $_coreConfig = null;
	
	/**
	 * Core registry
	 *
	 * @var \Magento\Framework\Registry
	 */
	protected $_coreRegistry = null;
	
	/**
	 * Object manager
	 *
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $_object = null;
	
	/**
	 * Cart
	 *
	 * @var \Magento\Checkout\Model\Cart
	 */
	protected $_cart = null;
	
	/**
	 * ProductRepository
	 * 
	 * @var \Magento\Catalog\Api\ProductRepositoryInterface
	 */
	protected $productRepository = null;
	
	/**
	 * 
	 * @var \Anowave\Ec\Model\Apply
	 */
	private $canApply = false;
	
	/**
	 * @var \Anowave\Ec\Model\Cache
	 */
	private $cache = null;
	
	/**
	 * @var \Anowave\Ec\Helper\Datalayer
	 */
	private $dataLayer = null;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\App\Config\ScopeConfigInterface $coreConfig
	 * @param \Magento\Framework\Registry $registry
	 * @param \Anowave\Ec\Helper\Data $helper
	 * @param \Magento\Framework\ObjectManagerInterface $object
	 * @param \Magento\Checkout\Model\Cart $cart
	 * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
	 * @param \Anowave\Ec\Model\Apply $apply
	 * @param \Anowave\Ec\Model\Cache $cache
	 * @param \Anowave\Ec\Helper\Datalayer $dataLayer
	 */
	public function __construct
	(
		\Magento\Framework\App\Config\ScopeConfigInterface $coreConfig,
		\Magento\Framework\Registry $registry, 
		\Anowave\Ec\Helper\Data $helper, 
		\Magento\Framework\ObjectManagerInterface $object,
		\Magento\Checkout\Model\Cart $cart,
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
		\Anowave\Ec\Model\Apply $apply,
		\Anowave\Ec\Model\Cache $cache,
		\Anowave\Ec\Helper\Datalayer $dataLayer
	) 
	{	
		$this->_cart 		 = $cart;
		$this->_helper 		 = $helper;
		$this->_object 		 = $object;
		$this->_coreConfig   = $coreConfig;
		$this->_coreRegistry = $registry;
		
		/**
		 * Set product repository
		 * 
		 * @var unknown
		 */
		$this->productRepository = $productRepository;
		
		/**
		 * Check if tracking should be applied
		 * 
		 * @var Boolean
		 */
		$this->canApply = $apply->canApply
		(
			$this->_helper->filter('Anowave\Ec\Block\Track')
		);
		
		/**
		 * @var \Anowave\Ec\Model\Cache
		 */
		$this->cache = $cache;
		
		/**
		 * Set dataLayer 
		 * 
		 * @var \Anowave\Ec\Helper\Datalayer
		 */
		$this->dataLayer = $dataLayer;
	}
	
	/**
	 * Block output modifier
	 *
	 * @param \Magento\Framework\View\Element\Template $block
	 * @param string $html
	 *
	 * @return string
	 */
	public function afterFetchView($block, $content)
	{
		return $content;
	}
	
	/**
	 * Block output modifier 
	 * 
	 * @param \Magento\Framework\View\Element\Template $block
	 * @param string $html
	 * 
	 * @return string
	 */
	public function afterToHtml($block, $content) 
	{
		if ($this->_helper->isActive() && $this->canApply)
		{			
			switch($block->getNameInLayout())
			{
				case 'product.info.addtocart':
				case 'product.info.addtocart.additional': 							return $this->augmentAddCartBlock($block, $content);
				case 'category.products.list': 										return $this->augmentListBlock($block, $content);
				case 'catalog.product.related':										return $this->augmentListRelatedBlock($block, $content);
				case 'product.info.upsell':											return $this->augmentListUpsellBlock($block, $content);
				case 'checkout.cart':												return $this->augmentCartBlock($block, $content);
				case 'checkout.root': 												return $this->augmentCheckoutBlock($block, $content);
				case 'checkout.cart.item.renderers.simple.actions.remove':
				case 'checkout.cart.item.renderers.bundle.actions.remove':
				case 'checkout.cart.item.renderers.virtual.actions.remove':
				case 'checkout.cart.item.renderers.default.actions.remove':
				case 'checkout.cart.item.renderers.grouped.actions.remove':
				case 'checkout.cart.item.renderers.downloadable.actions.remove':
				case 'checkout.cart.item.renderers.configurable.actions.remove':    return $this->augmentRemoveCartBlock($block, $content);
				case 'ec_noscript':													return $this->augmentAmp($block, $content);
					default:
						break;
			}
		}
		
		return $content;
	}

	/**
	 * Modify checkout output 
	 * 
	 * @param AbstractBlock $block
	 * @param string $content
	 * 
	 * @return string
	 */
	protected function augmentCheckoutBlock($block, $content)
	{
		return $content .= $block->getLayout()->createBlock('Anowave\Ec\Block\Track')->setTemplate('checkout.phtml')->setData
		(
			[
				'checkout_push' => $this->_helper->getCheckoutPush($block, $this->_cart, $this->_coreRegistry, $this->_object)
			]
		)
		->toHtml();
	}
	
	/**
	 * Modify cart output
	 *
	 * @param AbstractBlock $block
	 * @param string $content
	 * 
	 * @return string
	 */
	protected function augmentCartBlock($block, $content)
	{
		return $content .= $block->getLayout()->createBlock('Anowave\Ec\Block\Track')->setTemplate('cart.phtml')->setData
		(
			[
				'cart_push' => $this->_helper->getCartPush($block, $this->_cart, $this->_coreRegistry, $this->_object)
			]
		)
		->toHtml();
	}

	/**
	 * Modify categories listing output
	 *
	 * @param AbstractBlock $block
	 * @param string $content
	 */
	protected function augmentListBlock($block, $content)
	{	
		if (function_exists('libxml_use_internal_errors'))
		{
			libxml_use_internal_errors(true);
		}
		
		/**
		 * Load cache
		 * 
		 * @var string
		 */
		$cache = $this->cache->load(\Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());

		if ($cache)
		{
			return $cache;
		}
		
		/**
		 * Retrieve list of impression product(s)
		 * 
		 * @var array
		 */
		$products = [];
		
		foreach ($block->getLoadedProductCollection() as $product)
		{
			$products[] = $product;
		}
		
		/**
		 * Append tracking
		 */
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

		$query = new \DOMXPath($dom);
		
		$position = 1;
		
		foreach ($query->query($this->_helper->getListSelector()) as $key => $element)
		{
			if (isset($products[$key]))
			{
				/**
				 * Get current category
				 *  
				 * @var object
				 */
				$category = $this->_coreRegistry->registry('current_category');

				/**
				 * Add data-* attributes used for tracking dynamic values
				 */
				foreach ($query->query($this->_helper->getListClickSelector(), $element) as $a)
				{
					$click = $a->getAttribute('onclick');
						
					$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
					$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
					$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
					$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
					$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
					$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
					$a->setAttribute('data-quantity', 	1);
					$a->setAttribute('data-click',		$click);
					$a->setAttribute('data-store',		$this->_helper->getStoreName());
					$a->setAttribute('data-position',	$position);
					$a->setAttribute('data-event',		'productClick');
					$a->setAttribute('onclick',			'return AEC.click(this,dataLayer)');
				}
				
				if ('' !== $selector = $this->_helper->getCartCategorySelector())
				{
					foreach (@$query->query($selector, $element) as $a)
					{
						$click = $a->getAttribute('onclick');
					
						$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
						$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
						$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
						$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
						$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
						$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
						$a->setAttribute('data-quantity', 	1);
						$a->setAttribute('data-click',		$click);
						$a->setAttribute('data-position', 	$position);
						$a->setAttribute('data-store',		$this->_helper->getStoreName());
						$a->setAttribute('data-event',		'addToCart');
						$a->setAttribute('onclick',			'return AEC.ajaxList(this,dataLayer)');
					}
				}
			}
			
			$position++;
		}
		
		$content = $this->getDOMContent($dom, $doc);
		
		/**
		 * Save cache
		 */
		$this->cache->save($content, \Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());
		
		return $content;
	}
	
	/**
	 * Modify categories listing output
	 *
	 * @param AbstractBlock $block
	 * @param string $content
	 */
	protected function augmentListRelatedBlock($block, $content)
	{
		if (function_exists('libxml_use_internal_errors'))
		{
			libxml_use_internal_errors(true);
		}
		
		/**
		 * Remove empty spaces
		 */
		$content = trim($content);
		
		if (!strlen($content))
		{
			return $content;
		}
		
		/**
		 * Load cache
		 *
		 * @var string
		 */
		$cache = $this->cache->load(\Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());
		
		if ($cache)
		{
			return $cache;
		}
		
		/**
		 * Retrieve list of impression product(s)
		 *
		 * @var array
		 */
		$products = [];
		
		if ($block->getItems())
		{
			foreach ($block->getItems() as $product)
			{
				$products[] = $product;
			}
		}
		
		/**
		 * Append tracking
		 */
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		
		$query = new \DOMXPath($dom);
		
		$position = 1;
		
		foreach ($query->query($this->_helper->getListSelector()) as $key => $element)
		{
			if (isset($products[$key]))
			{
				/**
				 * Get all product categories
				 */
				$categories = $products[$key]->getCategoryIds();
				
				if (!$categories)
				{
					if (null !== $root = $this->_helper->getStoreRootDefaultCategoryId())
					{
						$categories[] = $root;
					}
				}
				
				if ($categories)
				{
					/**
					 * Load last category
					 */
					$category = $this->_object->create('\Magento\Catalog\Model\Category')->load
					(
						end($categories)
					);
				}
				else 
				{
					$category = null;
				}

				/**
				 * Add data-* attributes used for tracking dynamic values
				 */
				foreach ($query->query($this->_helper->getListClickSelector(), $element) as $a)
				{
					$click = $a->getAttribute('onclick');
					
					$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
					$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
					$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
					$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
					$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
					$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
					$a->setAttribute('data-quantity', 	1);
					$a->setAttribute('data-click',		$click);
					$a->setAttribute('data-store',		$this->_helper->getStoreName());
					$a->setAttribute('data-position',	$position);
					$a->setAttribute('data-event',		'productClick');
					$a->setAttribute('data-block',		$block->getNameInLayout());
					$a->setAttribute('onclick',			'return AEC.click(this,dataLayer)');
					
					if ($category)
					{
						$element->setAttribute('data-category', $this->_helper->getCategoryDetailList($products[$key], $category));
					}
				}

				/**
				 * Track "Add to cart" from Related products
				 */
				if ('' !== $selector = $this->_helper->getCartCategorySelector())
				{
					foreach (@$query->query($selector, $element) as $a)
					{
						$click = $a->getAttribute('onclick');
						
						$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
						$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
						$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
						$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
						$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
						$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
						$a->setAttribute('data-quantity', 	1);
						$a->setAttribute('data-click',		$click);
						$a->setAttribute('data-position', 	$position);
						$a->setAttribute('data-store',		$this->_helper->getStoreName());
						$a->setAttribute('data-event',		'addToCart');
						$a->setAttribute('data-block',		$block->getNameInLayout());
						$a->setAttribute('onclick',			'return AEC.ajaxList(this,dataLayer)');
					}
				}
			}
			
			$position++;
		}
		
		$content = $this->getDOMContent($dom, $doc);
		
		/**
		 * Save cache
		 */
		$this->cache->save($content, \Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());
		
		return $content;
	}
	
	/**
	 * Modify categories listing output
	 *
	 * @param AbstractBlock $block
	 * @param string $content
	 */
	protected function augmentListUpsellBlock($block, $content)
	{
		if (function_exists('libxml_use_internal_errors'))
		{
			libxml_use_internal_errors(true);
		}
		
		$content = trim($content);
		
		if (!strlen($content))
		{
			return $content;
		}
		
		/**
		 * Load cache
		 *
		 * @var string
		 */
		$cache = $this->cache->load(\Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());
		
		if ($cache)
		{
			return $cache;
		}
		
		/**
		 * Retrieve list of impression product(s)
		 *
		 * @var array
		 */
		$products = [];
		
		if ($block->getItems())
		{
			foreach ($block->getItems() as $product)
			{
				$products[] = $product;
			}
		}

		/**
		 * Append tracking
		 */
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		
		$query = new \DOMXPath($dom);
		
		$position = 1;
		
		foreach ($query->query($this->_helper->getListSelector()) as $key => $element)
		{
			if (isset($products[$key]))
			{
				/**
				 * Get all product categories
				 */
				$categories = $products[$key]->getCategoryIds();
				
				if (!$categories)
				{
					if (null !== $root = $this->_helper->getStoreRootDefaultCategoryId())
					{
						$categories[] = $root;
					}
				}
				
				if ($categories)
				{
					/**
					 * Load last category
					 */
					$category = $this->_object->create('\Magento\Catalog\Model\Category')->load
					(
						end($categories)
					);
				}
				else
				{
					$category = null;
				}
				
				/**
				 * Add data-* attributes used for tracking dynamic values
				 */
				foreach ($query->query($this->_helper->getListClickSelector(), $element) as $a)
				{
					$click = $a->getAttribute('onclick');
					
					$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
					$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
					$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
					$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
					$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
					$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
					$a->setAttribute('data-quantity', 	1);
					$a->setAttribute('data-click',		$click);
					$a->setAttribute('data-store',		$this->_helper->getStoreName());
					$a->setAttribute('data-position',	$position);
					$a->setAttribute('data-event',		'productClick');
					$a->setAttribute('data-block',		$block->getNameInLayout());
					$a->setAttribute('onclick',			'return AEC.click(this,dataLayer)');
					
					if ($category)
					{
						$element->setAttribute('data-category', $this->_helper->getCategoryDetailList($products[$key], $category));
					}
				}
				
				/**
				 * Track "Add to cart" from Related products
				 */
				if ('' !== $selector = $this->_helper->getCartCategorySelector())
				{
					foreach (@$query->query($selector, $element) as $a)
					{
						$click = $a->getAttribute('onclick');
						
						$a->setAttribute('data-id', 		$this->_helper->escapeDataArgument($products[$key]->getSku()));
						$a->setAttribute('data-name', 		$this->_helper->escapeDataArgument($products[$key]->getName()));
						$a->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($products[$key])));
						$a->setAttribute('data-category',   $this->_helper->escapeDataArgument($category->getName()));
						$a->setAttribute('data-list',		$this->_helper->escapeDataArgument($this->_helper->getCategoryList($category)));
						$a->setAttribute('data-brand',		$this->_helper->escapeDataArgument($this->_helper->getBrand($products[$key])));
						$a->setAttribute('data-quantity', 	1);
						$a->setAttribute('data-click',		$click);
						$a->setAttribute('data-position', 	$position);
						$a->setAttribute('data-store',		$this->_helper->getStoreName());
						$a->setAttribute('data-event',		'addToCart');
						$a->setAttribute('data-block',		$block->getNameInLayout());
						$a->setAttribute('onclick',			'return AEC.ajaxList(this,dataLayer)');
					}
				}
			}
			
			$position++;
		}
		
		$content = $this->getDOMContent($dom, $doc);
		
		/**
		 * Save cache
		 */
		$this->cache->save($content, \Anowave\Ec\Model\Cache::CACHE_LISTING . $block->getNameInLayout());
		
		return $content;
	}
	
	/**
	 * Modify remove from cart output
	 *
	 * @param AbstractBlock $block
	 * @param string $content
	 * 
	 * @return string
	 */
	
	protected function augmentRemoveCartBlock($block, $content)
	{
		/**
		 * Append tracking
		 */
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		
		/**
		 * Modify DOM
		 */
		
		$x = new \DOMXPath($dom);
		
		foreach ($x->query($this->_helper->getDeleteSelector()) as $element)
		{
			/**
			 * Get all product categories
			 */
			$categories = $block->getItem()->getProduct()->getCategoryIds();
			
			if (!$categories)
			{
				if (null !== $root = $this->_helper->getStoreRootDefaultCategoryId())
				{
					$categories[] = $root;
				}
			}
			
			$element->setAttribute('onclick', 'return AEC.remove(this, dataLayer)');
			
			if (!$this->_helper->useSimples())
			{
				$element->setAttribute('data-id', $this->_helper->escapeDataArgument($block->getItem()->getProduct()->getSku()));
			}
			else 
			{
				$element->setAttribute('data-id', $this->_helper->escapeDataArgument($block->getItem()->getSku()));
			}
			
			$element->setAttribute('data-name', 		  $this->_helper->escapeDataArgument($block->getItem()->getProduct()->getName()));
			$element->setAttribute('data-price', 		  $this->_helper->escapeDataArgument($this->_helper->getPrice($block->getItem()->getProduct())));
			$element->setAttribute('data-brand', 		  $this->_helper->escapeDataArgument($this->_helper->getBrand($block->getItem()->getProduct())));
			$element->setAttribute('data-quantity', (int) $block->getItem()->getQty());
			$element->setAttribute('data-event', 		  'removeFromCart');
			
			if ($categories)
			{
				/**
				 * Load last category
				 */
				$category = $this->_object->create('\Magento\Catalog\Model\Category')->load
				(
					end($categories)
				);
				
				$element->setAttribute('data-category', $this->_helper->getCategoryDetailList($block->getItem()->getProduct(), $category));
			}
		}
		
		
		return $this->getDOMContent($dom, $doc);
	}
	
	
	/**
	 * Modify add to cart output
	 * 
	 * @param AbstractBlock $block
	 * @param string $content
	 * 
	 * @return string
	 */
	protected function augmentAddCartBlock($block, $content)
	{
		$doc = new \DOMDocument('1.0','utf-8');
		$dom = new \DOMDocument('1.0','utf-8');
		
		@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		
		$x = new \DOMXPath($dom);

		foreach ($x->query($this->_helper->getCartSelector()) as $element)
		{
			$category = $this->_coreRegistry->registry('current_category');
			
			if (!$category)
			{
				/**
				 * Get all product categories
				 */
				$categories = $block->getProduct()->getCategoryIds();
					
				/**
				 * Load last category
				*/
				$category = $this->_object->create('\Magento\Catalog\Model\Category')->load
				(
					end($categories)
				);
			}
			
			/**
			 * Get existing onclick attribute
			 * 
			 * @var string
			 */
			$click = $element->getAttribute('onclick');
			
			$element->setAttribute('onclick', 			'return AEC.ajax(this,dataLayer)');
			$element->setAttribute('data-id', 			$this->_helper->escapeDataArgument($block->getProduct()->getSku()));
			$element->setAttribute('data-name', 		$this->_helper->escapeDataArgument($block->getProduct()->getName()));
			$element->setAttribute('data-price', 		$this->_helper->escapeDataArgument($this->_helper->getPrice($block->getProduct())));
			$element->setAttribute('data-category', 	$this->_helper->escapeDataArgument($category->getName()));
			$element->setAttribute('data-list', 		$this->_helper->getCategoryDetailList($block->getProduct(), $category));
			$element->setAttribute('data-brand', 		$this->_helper->getBrand($block->getProduct()));
			$element->setAttribute('data-click', 		$click);
			$element->setAttribute('data-event',		'addToCart');
			
			if ('grouped' == $block->getProduct()->getTypeId())
			{
				$element->setAttribute('data-grouped',1);
			}
			
			if ('configurable' == $block->getProduct()->getTypeId())
			{
				$element->setAttribute('data-configurable',1);
			}
			
			/**
			 * Set current store
			 */
			$element->setAttribute('data-currentstore', $this->_helper->getStoreName());
		}

		return $this->getDOMContent($dom, $doc);
	}
	
	/**
	 * Retrieves body
	 *
	 * @param DOMDocument $dom
	 * @param DOMDocument $doc
	 * @param string $decode
	 */
	public function getDOMContent(\DOMDocument $dom, \DOMDocument $doc, $debug = false, $originalContent = '')
	{
		try
		{
			$head = $dom->getElementsByTagName('head')->item(0);
			$body = $dom->getElementsByTagName('body')->item(0);
			
			if ($head instanceof \DOMElement)
			{
				foreach ($head->childNodes as $child)
				{
					$doc->appendChild($doc->importNode($child, true));
				}
			}
		
			if ($body instanceof \DOMElement)
			{
				foreach ($body->childNodes as $child)
				{
					$doc->appendChild($doc->importNode($child, true));
				}
			}
		}
		catch (\Exception $e)
		{
			
		}

		$content = $doc->saveHTML();
		
		return html_entity_decode($content, ENT_COMPAT, 'UTF-8');
	}
	
	/**
	 * Get current product
	 */
	public function getCurrentProduct()
	{
		return $this->_coreRegistry->registry('current_product');
	}
	
	/**
	 * Accelerated Mobile Pages support
	 *
	 * @param string $content
	 * @return string
	 */
	public function augmentAmp($block, $content)
	{
		if (!$this->_helper->supportsAmp())
		{
			return $content;
		}
	
		/**
		 * Parse content and detect amp-analytics snippet
		 */
		if (false !== strpos($content, 'amp-analytics'))
		{
			$doc = new \DOMDocument('1.0','utf-8');
			$dom = new \DOMDocument('1.0','utf-8');
				
			@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
				
			$x = new \DOMXPath($dom);
				
			$amp = $x->query('//amp-analytics');
	
			if ($amp->length > 0)
			{
				foreach ($amp as $node)
				{
					$params = $dom->createElement('script');
						
					$params->setAttribute('type','application/json');
						
					/**
					 * Enhanced Ecommerce parameters
					*/
					$params->nodeValue = json_encode($this->getAmpVariables($node, $block));
						
					$params = $node->appendChild($params);
				}
			}
			
			return $this->getDOMContent($dom, $doc);
		}
		
		return $content;
	}
	
	/**
	 * Generate AMP variables
	 *
	 * @param void
	 * @return []
	 */
	public function getAmpVariables(\DOMElement $node, $block)
	{
		$vars = [];
	
		/**
		 * Read pre-defined variables from static snippets and merge to global []
		*/
		foreach ($node->getElementsByTagName('script') as $script)
		{
			$vars = array_merge($vars, json_decode(trim($script->nodeValue), true));
		}
	
		/**
		 * Get visitor data
		 */
		$vars['vars']['visitor'] = json_decode($this->_helper->getVisitorPush($block), true);
		
		/**
		 * Read persistent dataLayer
		 */
		$data = $this->dataLayer->get();
		
		$vars['vars'] = array_merge_recursive($vars['vars'], $data);
		
		return $vars;
	}
}