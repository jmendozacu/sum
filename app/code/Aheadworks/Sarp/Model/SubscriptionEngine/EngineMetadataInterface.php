<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionEngine;

/**
 * Interface EngineMetadataInterface
 * @package Aheadworks\Sarp\Model\SubscriptionEngine
 */
interface EngineMetadataInterface
{
    /**
     * Get subscriptions engine code
     *
     * @return string
     */
    public function getCode();

    /**
     * Get subscription engine class name
     *
     * @return string
     */
    public function getClassName();

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get associated payment method code
     *
     * @return string
     */
    public function getPaymentMethod();

    /**
     * Get subscription plan validator class name
     *
     * @return string
     */
    public function getPlanValidatorClassName();

    /**
     * Get checkout config class name
     *
     * @return string
     */
    public function getCheckoutConfigClassName();

    /**
     * Get data sources
     *
     * @return array
     */
    public function getDataSources();

    /**
     * Get data source maps
     *
     * @return array
     */
    public function getDataSourceMaps();
}
