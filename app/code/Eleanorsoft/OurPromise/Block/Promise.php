<?php
namespace Eleanorsoft\OurPromise\Block;

class Promise extends \Magento\Framework\View\Element\Template
{
    private $_promise;

    protected $_pageConfig;
    protected $_scopeConfig;
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_pageConfig      = $pageConfig;
        $this->_scopeConfig     = $scopeConfig;
        $this->_coreRegistry    = $coreRegistry;

        parent::__construct($context);
    }

    public function getPromise()
    {
        return $this->_promise;
    }

    protected function _prepareLayout()
    {
        $this->_promise = $this->_coreRegistry->registry('promise');

        $this->_pageConfig->getTitle()->set(__('Our Promise'));
        $this->getLayout()->getBlock('page.main.title')
             ->setPageTitle($this->_promise->getTitle());

        return parent::_prepareLayout();
    }
}