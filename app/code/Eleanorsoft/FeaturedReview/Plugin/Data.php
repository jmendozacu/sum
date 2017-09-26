<?php

namespace Eleanorsoft\FeaturedReview\Plugin;

class Data
{
    private $_helper;

    public function __construct(
        \Eleanorsoft\FeaturedReview\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

    public function afterGetReviewStatuses(\Magento\Review\Helper\Data $subject, array $data)
    {
        $data[$this->_helper->getStatusFeaturedId()] = __(
            \Eleanorsoft\FeaturedReview\Helper\Data::STATUS_FEATURED
        );

        return $data;
    }
}
