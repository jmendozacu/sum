<?php
namespace Eleanorsoft\OurPromise\Block;

use Eleanorsoft\OurPromise\Model\Resource\Item\Collection;
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

        $this->_itemsCollection->setOrder('sort_order', 'asc');
        $this->_itemsCollection->addFieldToFilter('is_active', ['eq' => '1']);

        parent::__construct($context);
    }

    public function getTitle()
    {
        return "Promises";
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
     * @param \Eleanorsoft\OurPromise\Model\Item $item
     * @return string
     */
    public function getBackgroundImageUrl(\Eleanorsoft\OurPromise\Model\Item $item)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $item->getBackgroundImage();
    }
    
    /**
     * Generate url of the item icon
     *
     * @param \Eleanorsoft\OurPromise\Model\Item $item
     * @return string
     */
    public function getIconUrl(\Eleanorsoft\OurPromise\Model\Item $item)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $item->getIcon();
    }

    /**
     * Generate url of the item icon
     *
     * @param \Eleanorsoft\OurPromise\Model\Item $item
     * @return string
     */
    public function getPromiseUrl(\Eleanorsoft\OurPromise\Model\Item $item)
    {
        return $this->getUrl('ourpromise/promises/promise/slug/' . $item->getSlug());
    }
}