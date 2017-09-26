<?php

namespace Eleanorsoft\FeaturedReview\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    private $_status;

    const STATUS_FEATURED = 'Featured';

    public function __construct(
        \Magento\Review\Model\Review\Status $status
    ) {
        $this->_status = $status;
    }

    public function getStatusFeaturedId()
    {
        return (int)$this->_status
            ->getCollection()
            ->addFieldToFilter('status_code', ['eq' => self::STATUS_FEATURED])
            ->getFirstItem()
            ->getId();
    }
}
