<?php

namespace Eleanorsoft\Label\Helper;

use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;


/**
 * Class Data
 *
 * @package Eleanorsoft_Label
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Data extends AbstractHelper
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * Data constructor.
     * @param Context $context
     * @param Collection $collection
     */
    public function __construct
    (
        Context $context,
        Collection $collection
    )
    {
        parent::__construct($context);

        $this->collection = $collection;
    }

    /**
     * Return id new category
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getNewCategoryId()
    {
        $category = $this->collection
            ->addAttributeToFilter('name', 'new')
            ->getFirstItem();

        if ($category->isEmpty()) {
            return;
        }
        $id = (int)$category->getId();

        return $id;
    }
}