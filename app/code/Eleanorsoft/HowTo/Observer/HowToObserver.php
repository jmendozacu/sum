<?php

namespace Eleanorsoft\HowTo\Observer;

class HowToObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $_request;
    protected $_locator;
    protected $_storeManager;
    protected $_mediaDirectoryWrite;

    public function __construct(
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\Locator\LocatorInterface $locator,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->_locator = $locator;
        $this->_request = $request;
        $this->_storeManager = $storeManager;
        $this->_mediaDirectoryWrite = $fileSystem->getDirectoryWrite(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
        );
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $index      = 0;
            $newImages  = [];
            $dirName    = 'how-to';
            $dirUrl     = 'catalog/product/'.$dirName.'/';
            $product    = $this->_locator->getProduct();
            $productId  = $product->getId();
            $targetPath = $this->_mediaDirectoryWrite->getAbsolutePath(
                $dirUrl.$productId.'/'
            );
            $newHowToCollection = [];
            $howToCollection = json_decode($product->getHowTo());
            $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ).$dirUrl;

            foreach ($howToCollection as $item) {
                $index++;

                if (strpos($item->imageUrl, 'base64') !== false) {
                    $newImages[]        = $index;
                    $imageDataArray     = explode('base64,', $item->imageUrl);
                    $imageBase64String  = str_replace(' ', '+', end($imageDataArray));
                    $imageType          = explode('data:image/', $imageDataArray[0]);
                    $imageType          = '.'.str_replace(';', '', end($imageType));
                    $image              = base64_decode($imageBase64String);
                    $imageName          = $index.$imageType;
                    $imagePath          = $targetPath.$imageName;
                    $item->imageUrl     = $mediaUrl.$productId.'/'.$imageName;

                    if (!is_dir($targetPath)) {
                        mkdir($targetPath);
                    }

                    file_put_contents($imagePath, $image);
                } else {
                    $oldImageIndex = explode('/', $item->imageUrl);
                    $oldImageIndex = end($oldImageIndex)[0];

                    $newImages[] = $oldImageIndex;
                }

                $newHowToCollection[] = $item;
            }

            $oldImages       = array_diff(scandir($targetPath), array('..', '.'));
            $oldImageIndexes = array_map(function ($item) { return $item[0]; }, $oldImages);
            $imagesToRemove  = array_diff($oldImageIndexes, $newImages);

            foreach ($oldImages as $oldImage) {
                if (in_array($oldImage[0], $imagesToRemove)) {
                    unlink($targetPath.$oldImage);
                }
            }

            $product->setHowTo(json_encode($newHowToCollection));
            $product->save();
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
        }
    }
}
