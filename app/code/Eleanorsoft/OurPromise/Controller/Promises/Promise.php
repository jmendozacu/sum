<?php

namespace Eleanorsoft\OurPromise\Controller\Promises;

class Promise extends \Magento\Framework\App\Action\Action
{
    protected $_coreRegistry;
    protected $_redirectFactory;
    protected $_resultPageFactory;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \Eleanorsoft\OurPromise\Model\Resource\Item\Collection $itemsCollection
    )
    {
        $this->_coreRegistry        = $coreRegistry;
        $this->_redirectFactory     = $redirectFactory;
        $this->_itemsCollection     = $itemsCollection;
        $this->_resultPageFactory   = $resultPageFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $slug = $this->getRequest()->getParam('slug');

        if ($slug) {
            $this->_itemsCollection->addFieldToFilter('is_active', ['eq' => '1']);
            $this->_itemsCollection->addFieldToFilter('slug', ['eq' => $slug]);

            $promise = $this->_itemsCollection->getFirstItem();

            if ($promise->getId()) {
                $this->_coreRegistry->register('promise', $promise);

                return $this->_resultPageFactory->create();
            }
        }

        return $this->_redirectFactory->create()->setPath('404notfound');
    }
}