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

class Refund implements ObserverInterface
{
	/**
	 * Block factory
	 *
	 * @var \Magento\Framework\View\Element\BlockFactory
	 */
	protected $blockFactory;
	
	/**
	 * @var \Anowave\Ec\Helper\Data
	 */
	protected $helper = null;
	
	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
	protected $storeManager = null;
	
	/**
	 * @var \Magento\Framework\Message\ManagerInterfa
	 */
	protected $messageManager;
	
	/**
	 * @var \Magento\Catalog\Model\ProductFactory
	 */
	protected $productFactory;
	
	/**
	 * @var \Magento\Catalog\Model\CategoryRepository
	 */
	protected $categoryRepository;
	
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\View\Element\BlockFactory $blockFactory
	 * @param \Anowave\Ec\Helper\Data $helper
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param \Magento\Framework\Message\ManagerInterface $messageManager
	 * @param \Magento\Catalog\Model\ProductFactory $productFactory
	 * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
	 */
	public function __construct
	(
		\Magento\Framework\View\Element\BlockFactory $blockFactory,
		\Anowave\Ec\Helper\Data $helper,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Catalog\Model\ProductFactory $productFactory,
		\Magento\Catalog\Model\CategoryRepository $categoryRepository
	)
	{
		$this->blockFactory 	= $blockFactory;
		$this->helper 			= $helper;
		$this->storeManager 	= $storeManager;
		$this->messageManager 	= $messageManager;
		$this->productFactory   = $productFactory;
		
		/**
		 * Set category repository 
		 * 
		 * @var \Magento\Catalog\Model\CategoryRepository $categoryRepository
		 */
		$this->categoryRepository = $categoryRepository;
	}
	
	/**
	 * Add order information into GA block to render on checkout success pages
	 *
	 * @param EventObserver $observer
	 * @return void
	 */
	public function execute(EventObserver $observer)
	{
		$this->refund($observer->getPayment()->getOrder());
	}
	
	/**
	 * Refund order 
	 * 
	 * @param \Magento\Sales\Model\Order $order
	 * @return \Anowave\Ec\Observer\Refund|boolean
	 */
	protected function refund(\Magento\Sales\Model\Order $order)
	{
		if ($order->getTotalRefunded() > 0)
		{
			if ($order->getIsVirtual())
			{
				$address = $order->getBillingAddress();
			}
			else
			{
				$address = $order->getShippingAddress();
			}
				
			$refund = array
			(
				'ecommerce' => array
				(
					'refund' => array
					(
						'actionField' => array
						(
							'id' => $order->getRealOrderId()
						),
						'products' => array()
					)
				)
			);
				
			foreach ($order->getAllVisibleItems() as $item)
			{
				$collection = [];
				
				if ($item->getProduct())
				{
					$entity = $this->productFactory->create()->load
					(
						$item->getProduct()->getId()
					);
					
					$collection = $entity->getCategoryIds();
				}

				if ($collection)
				{
					$category = $this->categoryRepository->get(end($collection));
				}
				else 
				{
					$category = null;
				}
	
				/**
				 * Get product name
				*/
				$args = new \stdClass();
					
				$args->id 	= $item->getSku();
				$args->name = $item->getName();

				/**
				 * Product variant(s)
				 * 
				 * @var []
				 */
				$variant = [];

				if ('configurable' === $item->getProductType())
				{
					$options = (array) $item->getProductOptions();
					
					if (isset($options['info_buyRequest']))
					{
						$info = new \Magento\Framework\DataObject($options['info_buyRequest']);
						
						/**
						 * Construct variant
						 */
						foreach ((array) $info->getSuperAttribute() as $id => $option)
						{
							/**
							 * @todo: Pull attribute data
							 */
							$attribute = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Catalog\Model\ResourceModel\Eav\Attribute')->load($id);
								
							if ($attribute->usesSource())
							{
								$variant[] = join(\Anowave\Ec\Helper\Data::VARIANT_DELIMITER_ATT, array
								(
									$this->escape($attribute->getFrontendLabel()),
									$this->escape($attribute->getSource()->getOptionText($option))
								));
							}
						}
					}
				}
	
				$data = 
				[
					'name' 		=> $this->escape($args->name),
					'id'		=> $this->escape($args->id),
					'price' 	=> $item->getPrice(),
					'quantity' 	=> $item->getQtyOrdered(),
					'variant'	=> join(\Anowave\Ec\Helper\Data::VARIANT_DELIMITER, $variant)
				];
				
				if ($category)
				{
					$data['category'] = $this->escape($category->getName());
				}
				
				$refund['ecommerce']['refund']['products'][] = $data;
			}
			
			$analytics = curl_init('https://ssl.google-analytics.com/collect');
				
			curl_setopt($analytics, CURLOPT_HEADER, 		0);
			curl_setopt($analytics, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($analytics, CURLOPT_POST, 			1);
			curl_setopt($analytics, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($analytics, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($analytics, CURLOPT_USERAGENT,		'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
				
				
			$ua = $this->helper->getConfig('ec/general/account');
			
			if ($ua)
			{
				$affiliation = $this->storeManager->getStore($order->getStoreId())->getName();
	
				$payload = array
				(
					'v' 	=> 1,
					'tid' 	=> $ua,
					'cid' 	=> sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',mt_rand(0, 0xffff), mt_rand(0, 0xffff),mt_rand(0, 0xffff),mt_rand(0, 0x0fff) | 0x4000,mt_rand(0, 0x3fff) | 0x8000,mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)),
					't'		=> 'event',
					'ec'	=> 'Ecommerce',
					'ea'	=> 'Refund',
					'ta'	=> $affiliation,
					'ni'	=> 1,
					'ti'	=> $refund['ecommerce']['refund']['actionField']['id'],
					'tr'	=> (float) $order->getTotalRefunded(),
					'pa'	=> 'refund'
			
				);

				foreach ($refund['ecommerce']['refund']['products'] as $index => $product)
				{
					$key = 1 + $index;
	
					$payload["pr{$key}id"] = $product['id'];
					$payload["pr{$key}qt"] = $product['quantity'];
				}
				
				curl_setopt($analytics, CURLOPT_POSTFIELDS, utf8_encode
				(
					http_build_query($payload)
				));
			}

			try
			{
				$response = curl_exec($analytics);
				
				if (!curl_error($analytics) && $response)
				{
					$this->messageManager->addNotice("Refund tracking data sent to Google Analytics successfully. (ID:$ua)");
				}
				else
				{
					$this->messageManager->addWarning('Failed to send refund tracking data to Google Analytics.');
				}
			}
			catch (Exception $e)
			{
				$this->messageManager->addWarning
				(
					$e->getMessage()
				);
			}
				
			return $this;
		}
	
		return true;
	}
	
	/**
	 * Get an associative array of [store_id => root_category_id] values for all stores
	 * @return array
	 */
	public function getAllStoreRootCategories()
	{
		$roots = [];
		
		foreach ($this->storeManager->getStores() as $store) 
		{
			$roots[$store->getId()] = $store->getRootCategoryId();
		}
		
		return $roots;
	}
	
	/**
	 * Get root category id
	 * 
	 * @param unknown $store
	 * @throws \Exception
	 */
	public function getStoreRootCategoryId($store)
	{
		if (is_int($store)) 
		{
			$store = $this->storeManager->getStore($store);
		}
	
		if (is_string($store)) 
		{
			foreach ($this->storeManager->getStores() as $model) 
			{
				if ($model->getCode() == $store) 
				{
					$store = $model;
					
					break;
				}
			}
		}

		if ($store instanceof \Magento\Store\Model\Store) 
		{
			return $store->getRootCategoryId();
		}

		throw new \Exception("Store $store does not exist anymore");
	}
	
	/**
	 * Escape quotes
	 *
	 * @param string $string
	 */
	public function escape($data)
	{
		return $this->helper->escape($data);
	}
}