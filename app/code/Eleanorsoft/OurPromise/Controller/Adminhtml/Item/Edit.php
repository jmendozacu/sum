<?php
namespace Eleanorsoft\OurPromise\Controller\Adminhtml\Item;

class Edit extends Index
{
    /**
     */
    public function execute()
    {
        $itemId = $this->getRequest()->getParam('id');
        /** @var \Atak\Events\Model\Item $model */
        $model = $this->_itemFactory->create();

        if ($itemId) {
            $model->load($itemId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getItemData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('ourpromise_item', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Eleanorsoft_OurPromise::ourpromise_items');
        $resultPage->getConfig()->getTitle()->prepend(__('Promises Item'));

        return $resultPage;
    }
}