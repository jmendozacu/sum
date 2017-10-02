<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Block\Adminhtml\Subscription\Info\Orders;

/**
 * Class Pager
 * @package Aheadworks\Sarp\Block\Adminhtml\Subscription\Info\Orders
 */
class Pager extends \Magento\Framework\View\Element\Template
{
    /**
     * @var int
     */
    private $itemsCount;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $pageSize = 5;

    /**
     * Get items count
     *
     * @return int
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * Set items count
     *
     * @param int $itemsCount
     * @return $this
     */
    public function setItemsCount($itemsCount)
    {
        $this->itemsCount = $itemsCount;

        return $this;
    }

    /**
     * Get current page
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set current page
     *
     * @param int $currentPage
     * @return $this
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get page size
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Set page size
     *
     * @param int $pageSize
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * Get last page number
     *
     * @return int
     */
    public function getLastPage()
    {
        return ceil($this->getItemsCount() / $this->getPageSize());
    }

    /**
     * Is current page first
     *
     * @return bool
     */
    public function isFirstPage()
    {
        return $this->getCurrentPage() == 1;
    }

    /**
     * Is current page last
     *
     * @return bool
     */
    public function isLastPage()
    {
        return $this->getCurrentPage() >= $this->getLastPage();
    }

    /**
     * Check if page is current
     *
     * @param string $page
     * @return bool
     */
    public function isPageCurrent($page)
    {
        return $this->getCurrentPage() == $page;
    }
}
