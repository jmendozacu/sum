<?php
namespace Atak\Videoblocks\Controller\Adminhtml\Item;

use Atak\Videoblocks\Model\ItemFactory;
use Magento\Framework\File\UploaderFactory;
use \Magento\Framework\Filesystem;

class Index extends \Magento\Backend\App\Action
{
	/**
	* @var \Magento\Framework\View\Result\PageFactory
	*/
	protected $_resultPageFactory;

	/**
	 * @var \Magento\Framework\View\Result\Page
	 */
	protected $_resultPage;

	/**
	 * News model factory
	 *
	 * @var \Atak\Videoblocks\Model\ItemFactory
	 */
	protected $_itemFactory;

	/**
	 * @var \Magento\Framework\Registry
	 */
	protected $_coreRegistry;
	protected $fileSystem;
	protected $uploaderFactory;

	/**
	 * Constructor
	 *
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		ItemFactory $itemFactory,
		Filesystem $fileSystem,
		UploaderFactory $uploaderFactory
	) {
		 parent::__construct($context);
		$this->_coreRegistry = $coreRegistry;
		 $this->_resultPageFactory = $resultPageFactory;
		$this->_itemFactory = $itemFactory;
		$this->fileSystem = $fileSystem;
		$this->uploaderFactory = $uploaderFactory;
	}

	public function execute()
	{
		//Call page factory to render layout and page content
		$this->_setPageData();
		return $this->getResultPage();
	}

	/*
	 * Check permission via ACL resource
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Atak_Videoblocks::videoblocks_manage');
	}

	/**
	 * @return \Magento\Framework\View\Result\Page
	 */
	public function getResultPage()
	{
		if (is_null($this->_resultPage)) {
			$this->_resultPage = $this->_resultPageFactory->create();
		}
		return $this->_resultPage;
	}

	protected function _setPageData()
	{
		$resultPage = $this->getResultPage();
		$resultPage->setActiveMenu('Atak_Videoblocks::videoblocks_items');
		$resultPage->getConfig()->getTitle()->prepend((__('Videoblocks')));

		//Add bread crumb
		#$resultPage->addBreadcrumb(__('Lookbook'), __('Lookbook'));
		#$resultPage->addBreadcrumb(__('Hello World'), __('Manage Blogs'));

		return $this;
	}

}
?>