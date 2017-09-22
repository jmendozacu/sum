<?php
namespace Atak\Videoblocks\Block;

use Atak\Videoblocks\Model\Resource\Item\Collection;
use Magento\Framework\UrlInterface;

class Listing extends \Magento\Framework\View\Element\Template
{
    public $_itemsCollection;
    public $_storeManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Collection $itemsCollection
    ) {
        $this->_itemsCollection = $itemsCollection;
        $this->_storeManager = $context->getStoreManager();

        $this->_itemsCollection->setOrder('order_number', 'asc');

        parent::__construct($context);
    }

    public function getTitle()
    {
        return "Videoblocks";
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->_itemsCollection;
    }

    /**
     * Generate url of the item image
     *
     * @param \Atak\Videoblocks\Model\Item $item
     * @return string
     */
    public function getImageUrl(\Atak\Videoblocks\Model\Item $item)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $item->getImage();
    }

    /**
     * Generate youtube video code from the item youtube url
     *
     * @param \Atak\Videoblocks\Model\Item $item
     * @return string
     */
    public function getYouTubeCode(\Atak\Videoblocks\Model\Item $item)
    {
        $code = explode('/', $item->getVideoUrl());
        $code = end($code);

        if (strpos($code, '?v=') !== false) {
            $code = explode('?v=', $code);
            $code = end($code);
        }

        return $code;
    }
}