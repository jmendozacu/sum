<?php

namespace Atak\Videoblocks\Controller\Adminhtml\Item;

use Atak\Videoblocks\Controller\Adminhtml\Item\Index;

class Delete extends Index
{
    /**
     * @return void
     */
    public function execute()
    {
        $newsId = (int) $this->getRequest()->getParam('id');

        if ($newsId) {
            /** @var $newsModel \Atak\Videoblocks\Model\Item */
            $newsModel = $this->_itemFactory->create();
            $newsModel->load($newsId);

            // Check this news exists or not
            if (!$newsModel->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
            } else {
                try {
                    // Delete news
                    $newsModel->delete();
                    $this->messageManager->addSuccess(__('The item has been deleted.'));

                    // Redirect to grid page
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
                }
            }
        }
    }
}