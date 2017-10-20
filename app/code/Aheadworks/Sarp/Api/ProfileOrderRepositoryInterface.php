<?php
namespace Aheadworks\Sarp\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Profile Order CRUD interface
 * @api
 */
interface ProfileOrderRepositoryInterface
{
    /**
     * Retrieve profile orders matching the specified criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Aheadworks\Sarp\Api\Data\ProfileOrderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
