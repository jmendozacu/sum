<?php

namespace Eleanorsoft\TotalScore\Block;

class TotalScore extends \Magento\Framework\View\Element\Template
{
    protected $_reviewFactory;

    public function __construct(
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->_reviewFactory = $reviewFactory;

        parent::__construct($context);
    }

    public function getTotalScore($product)
    {
        $totalScore = $product->getTotalScore();

        return substr(
            $totalScore ? $totalScore : $this->getRatingSummary($product)
        , 0, 3);
    }

    private function getRatingSummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary(
            $product, $this->_storeManager->getStore()->getId()
        );

        return ($product->getRatingSummary()->getRatingSummary() * 5) / 100;
    }
}
