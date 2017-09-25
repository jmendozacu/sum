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
namespace Anowave\Ec\Model;

class Cache extends \Magento\Framework\Cache\Frontend\Decorator\TagScope
{
	const CACHE_LISTING = 'ec_cache_listing_';
	const CACHE_DETAILS = 'ec_cache_details_';
	
	/**
	 * Cache type code unique among all cache types
	 */
	const TYPE_IDENTIFIER = 'ec_cache';

	/**
	 * Cache tag used to distinguish the cache type from all other cache
	 */
	const CACHE_TAG = 'EC';

	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
	protected $storeManager;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\App\Cache\Type\FrontendPool $cacheFrontendPool
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 */
	public function __construct
	(
		\Magento\Framework\App\Cache\Type\FrontendPool $cacheFrontendPool,
		\Magento\Store\Model\StoreManagerInterface $storeManager
	)
	{
		parent::__construct($cacheFrontendPool->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);
		
		$this->storeManager = $storeManager;
	}
	
	/**
	 * Enforce marking with a tag
	 *
	 * {@inheritdoc}
	 */
	public function save($data, $identifier, array $tags = [], $lifeTime = null)
	{
		if (!$this->useCache())
		{
			return false;
		}
		
		return parent::save(serialize($data), $this->getCacheId($identifier), [self::CACHE_TAG], 600);
	}
	
	/**
	 * Load cache 
	 * 
	 * @see \Magento\Framework\Cache\Frontend\Decorator\Bare::load()
	 */
	public function load($identifier)
	{
		if (!$this->useCache())
		{
			return false;
		}
		
		return unserialize($this->_getFrontend()->load($this->getCacheId($identifier)));
	}
	
	/**
	 * Generate unique cache id
	 *
	 * @param string $prefix
	 */
	protected function generateCacheId($prefix)
	{
		/**
		 * Push current store to make cache store specific
		 *
		 * @var int
		 */
		$p[] = $this->storeManager->getStore()->getId();
	
		/**
		 * Push request URI
		 *
		 * @var string
		*/
		$p[] = array
		(
			$_SERVER['REQUEST_URI']
		);
	
		foreach (array($_GET, $_POST, $_FILES) as $request)
		{
			if ($request)
			{
				$p[] = $request;
			}
		}
	
		$p = md5(serialize($p));
	
		/**
		 * Merge
		*/
		return "{$prefix}_{$p}";
	}
	
	/**
	 * Getenerate unique cache id 
	 * 
	 * @param string $identifier
	 */
	public function getCacheId($identifier)
	{
		return $this->generateCacheId($identifier);
	}
	
	/**
	 * Check if can use cache
	 * 
	 * @return bool
	 */
	protected function useCache()
	{
		return true;
	}
}