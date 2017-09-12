<?php

namespace Atak\Testimonials\Controller\Adminhtml\Item;

use Atak\Testimonials\Controller\Adminhtml\Item\Index;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends Index
{
    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $newsModel = $this->_itemFactory->create();
            $newsId = $this->getRequest()->getParam('id');

            $destination = $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('testimonials');

            $oldImage = '';
            $formData = $this->getRequest()->getParam('item');
            if (isset($formData['id'])) {
                $newsModel->load($formData['id']);
                $oldImage = $newsModel->getImage();
            }
            $newsModel->setData($formData);

            if (isset($_FILES['image']) and $_FILES['image']['size'] > 0) {
                try {
                    $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);
                    if ($result = $uploader->save($destination)) {
                        $newsModel->setImage('testimonials' . $result['file']);
                    } else {
                        $newsModel->setImage($oldImage);
                    }

                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __($e->getMessage())
                    );
                    $newsModel->setImage($oldImage);
                }
            } else {
                $newsModel->setImage($oldImage);
            }

            if (!$newsModel->getId()) {
                $newsModel->setCreatedAt(date('Y-m-d H:i:s'));
            }

            try {
                // Save news
                $newsModel->save();

                // Display success message
                $this->messageManager->addSuccess(__('The item has been saved.'));

                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $newsModel->getId(), '_current' => true]);
                    return;
                }

                // Go to grid page
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($formData);
            $this->_redirect('*/*/edit', ['id' => $newsId]);
        }
    }
}