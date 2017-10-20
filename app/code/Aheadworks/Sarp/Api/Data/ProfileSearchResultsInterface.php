<?php
namespace Aheadworks\Sarp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for subscription profile search results
 * @api
 */
interface ProfileSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get profiles list
     *
     * @return \Aheadworks\Sarp\Api\Data\ProfileInterface[]
     */
    public function getItems();

    /**
     * Set profiles list
     *
     * @param \Aheadworks\Sarp\Api\Data\ProfileInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
