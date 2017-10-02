<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionEngine;

/**
 * Class RestrictionsPool
 * @package Aheadworks\Sarp\Model\SubscriptionEngine
 */
class RestrictionsPool
{
    /**
     * @var \Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterfaceFactory
     */
    private $restrictionsFactory;

    /**
     * @var array
     */
    private $restrictions = [];

    /**
     * @var RestrictionsInterface[]
     */
    private $restrictionsInstances = [];

    /**
     * @param RestrictionsInterfaceFactory $restrictionsFactory
     * @param array $restrictions
     */
    public function __construct(
        \Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterfaceFactory $restrictionsFactory,
        $restrictions = []
    ) {
        $this->restrictionsFactory = $restrictionsFactory;
        $this->restrictions = $restrictions;
    }

    /**
     * Retrieves restrictions instance
     *
     * @param string $engineCode
     * @return RestrictionsInterface
     * @throws \Exception
     */
    public function getRestrictions($engineCode)
    {
        if (!isset($this->restrictionsInstances[$engineCode])) {
            if (!isset($this->restrictions[$engineCode])) {
                throw new \Exception(sprintf('Unknown subscription engine: %s requested', $engineCode));
            }
            $restrictionsInstance = $this->restrictionsFactory->create(['data' => $this->restrictions[$engineCode]]);
            if (!$restrictionsInstance instanceof RestrictionsInterface) {
                throw new \Exception(
                    sprintf('Restrictions instance %s does not implement required interface.', $engineCode)
                );
            }
            $this->restrictionsInstances[$engineCode] = $restrictionsInstance;
        }
        return $this->restrictionsInstances[$engineCode];
    }
}
