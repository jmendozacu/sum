<?php

namespace Eleanorsoft\FeaturedReview\Block;

class FeaturedReview extends \Magento\Framework\View\Element\Template
{
    protected $_review;
    protected $_helper;

    public function __construct(
        \Magento\Review\Model\Review $review,
        \Eleanorsoft\FeaturedReview\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->_review = $review;
        $this->_helper = $helper;

        parent::__construct($context);
    }

    public function getFeaturedReview($product)
    {
        return $this->_review
            ->getResourceCollection()
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->addEntityFilter('product', $product->getId())
            ->addStatusFilter($this->_helper->getStatusFeaturedId())
            ->getFirstItem();
    }
}
