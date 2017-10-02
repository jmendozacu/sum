<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\Profile;

use Aheadworks\Sarp\Model\SubscriptionPlan\Source\StartDateType;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Stdlib\DateTime\DateTime as CoreDateTime;

/**
 * Class StartDateResolver
 * @package Aheadworks\Sarp\Model\Profile
 */
class StartDateResolver
{
    /**
     * @var CoreDateTime
     */
    private $coreDate;

    /**
     * @param CoreDateTime $coreDate
     */
    public function __construct(CoreDateTime $coreDate)
    {
        $this->coreDate = $coreDate;
    }

    /**
     * Get start date
     *
     * @param string $startDateType
     * @param int|null $dayOfMonth
     * @return string
     */
    public function getStartDate($startDateType, $dayOfMonth = null)
    {
        $startDate = null;
        switch ($startDateType) {
            case StartDateType::MOMENT_OF_PURCHASE:
                $startDate = $this->coreDate->gmtDate(DateTime::DATETIME_PHP_FORMAT, 'now');
                break;
            case StartDateType::LAST_DAY_OF_CURRENT_MONTH:
                $startDate = $this->coreDate->gmtDate(DateTime::DATETIME_PHP_FORMAT, 'last day of this month');
                break;
            case StartDateType::EXACT_DAY_OF_MONTH:
                list($day, $month, $year, $hours, $minutes, $seconds) = [
                    $this->coreDate->gmtDate('d'),
                    $this->coreDate->gmtDate('m'),
                    $this->coreDate->gmtDate('Y'),
                    $this->coreDate->gmtDate('H'),
                    $this->coreDate->gmtDate('i'),
                    $this->coreDate->gmtDate('s')
                ];
                $format = '%s-%s-%s %s:%s:%s';
                if ((int)$day > $dayOfMonth) {
                    $format = '+1 month ' . $format;
                }
                $startDate = $this->coreDate->gmtDate(
                    DateTime::DATETIME_PHP_FORMAT,
                    sprintf($format, $year, $month, $dayOfMonth, $hours, $minutes, $seconds)
                );
                break;
            default:
                break;
        }
        return $startDate;
    }
}
