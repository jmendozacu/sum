<?php

namespace Eleanorsoft\AheadworksSarp\Helper;

use Aheadworks\Sarp\Model\ResourceModel\Profile\Order\Collection;
use \Magento\Framework\App\Helper\AbstractHelper;
use Aheadworks\Sarp\Api\Data\ProfileInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Aheadworks\Sarp\Api\ProfileRepositoryInterface;

/**
 * Class Data
 *
 * @package Eleanorsoft_AheadworksSarp
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Data extends AbstractHelper
{

    /**
     * @var ProfileRepositoryInterface
     */
    protected $profileRepository;

    /**
     * @var Collection
     */
    protected $collectionOrder;

    /**
     * Data constructor.
     * @param Context $context
     * @param ProfileRepositoryInterface $profileRepository
     * @param Collection $collectionOrder
     */
    public function __construct
    (
        Context $context,
        ProfileRepositoryInterface $profileRepository,
        Collection $collectionOrder
    )
    {
        parent::__construct($context);
        $this->profileRepository = $profileRepository;
        $this->collectionOrder = $collectionOrder;
    }

    /**
     *  Get profile
     *
     * @param $profileId
     * @return \Aheadworks\Sarp\Api\Data\ProfileInterface
     * @throws LocalizedException
     */
    public function getProfile($profileId)
    {
        return $this->profileRepository->get($profileId);
    }

    /**
     * Retrieve id products from profile
     *
     * @param ProfileInterface $profile
     * @return array
     */
    public function getProfileProductIds(ProfileInterface $profile)
    {
        $items = $profile->getItems();
        $data = [];
        foreach ($items as $item) {
            $data[] =
                [
                    'product_id' => (int)$item->getProductId(),
                    'qty' => (int)$item->getQty()
                ];
        }
        return $data;
    }

    /**
     * Returns the updated date with the skip next date
     *
     * @param ProfileInterface $profile
     * @return string
     */
    public function getSkipNextDate(ProfileInterface $profile)
    {

        $profile_id = $profile->getProfileId();
        $count_order = $this->collectionOrder
            ->addFieldToFilter('profile_id', $profile_id)
            ->addFieldToFilter('sales_order_table.status', array("neq" => "cancelled"))
            ->count();


        $period = $profile->getBillingPeriod();
        $frequency = $profile->getBillingFrequency();
        $start_date = $profile->getStartDate();

        $count = (1 + $count_order) * $frequency;
        $date = $start_date . ' + ' . $count;

        switch ($period) {
            case "month":
                $date .= ' months';
                break;
            case "day":
                $date .= ' days';
                break;
        }
        $passed_seconds = strtotime($date);
        $next_date = date('Y-m-d',$passed_seconds);

        return $next_date;
    }

    /**
     * Returns a large date between
     * the current date and the current subscription date
     *
     * @param ProfileInterface $profile
     * @return false|string
     */
    public function getStartDate(ProfileInterface $profile)
    {
        $profile_start_date = $profile->getStartDate();
        $current_date = date('Y-m-d');

        $date = ($profile_start_date < $current_date) ? $current_date : $profile_start_date;

        return $date;
    }
}
