<?php
namespace Atak\Praise\Block;

use Atak\Praise\Model\Resource\Item\Collection;
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
        return "Praise";
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
     * @param \Atak\Praise\Model\Item $item
     * @return string
     */
    public function getImageUrl(\Atak\Praise\Model\Item $item)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $item->getImage();
    }
}