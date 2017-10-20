<?php
namespace Aheadworks\Sarp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SubscriptionsCartAddressSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get addresses list
     *
     * @return \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface[]
     */
    public function getItems();

    /**
     * Set addresses list
     *
     * @param \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

    /**
     * Get shipping address item
     *
     * @return \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface|null
     */
    public function getShippingAddress();

    /**
     * Get billing address item
     *
     * @return \Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface|null
     */
    public function getBillingAddress();
}
