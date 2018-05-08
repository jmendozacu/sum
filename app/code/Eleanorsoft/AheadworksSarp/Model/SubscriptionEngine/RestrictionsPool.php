<?php

namespace Eleanorsoft\AheadworksSarp\Model\SubscriptionEngine;
use Aheadworks\Sarp\Model\SubscriptionEngine\Core\Restrictions\Provider as CoreRestrictionsProvider;
use Aheadworks\Sarp\Model\SubscriptionEngine\EngineMetadataPool;
use Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsPool as BaseRestrictionsPool;


/**
 * Class RestrictionsPool
 * Extends base class EngineMetadataPool, for add action: suspend, activate
 *
 * @package Eleanorsoft_AheadworksSarp
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class RestrictionsPool extends BaseRestrictionsPool
{

    /**
     * RestrictionsPool constructor.
     * @param \Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterfaceFactory $restrictionsFactory
     * @param EngineMetadataPool $engineMetadataPool
     * @param CoreRestrictionsProvider $coreRestrictionsProvider
     * @param array $restrictions
     */
    public function __construct
    (
        \Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterfaceFactory $restrictionsFactory,
        EngineMetadataPool $engineMetadataPool,
        CoreRestrictionsProvider $coreRestrictionsProvider,
        array $restrictions = []
    )
    {
        parent::__construct($restrictionsFactory, $engineMetadataPool, $coreRestrictionsProvider, $restrictions);
    }
}