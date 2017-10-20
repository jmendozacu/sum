<?php
namespace Aheadworks\Sarp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for subscription profile order search results
 * @api
 */
interface ProfileOrderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get profile orders list
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileOrderInterface[]
     */
    public function getItems();

    /**
     * Set profile orders list
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileOrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
