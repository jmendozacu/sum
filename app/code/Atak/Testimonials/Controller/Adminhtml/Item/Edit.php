<?php
namespace Atak\Testimonials\Controller\Adminhtml\Item;

use Atak\Testimonials\Controller\Adminhtml\Item\Index;

class Edit extends Index
{
    /**
     */
    public function execute()
    {
        $newsId = $this->getRequest()->getParam('id');
        /** @var \Atak\Events\Model\Item $model */
        $model = $this->_itemFactory->create();

        if ($newsId) {
            $model->load($newsId);
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
        $this->_coreRegistry->register('testimonials_item', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Atak_Testimonials::testimonials_items');
        $resultPage->getConfig()->getTitle()->prepend(__('Testimonials Item'));

        return $resultPage;
    }
}