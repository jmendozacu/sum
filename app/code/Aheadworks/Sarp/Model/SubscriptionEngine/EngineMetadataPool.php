<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\SubscriptionEngine;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class EngineMetadataPool
 * @package Aheadworks\Sarp\Model\SubscriptionEngine
 */
class EngineMetadataPool
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $metadata = [];

    /**
     * @var EngineMetadataInterface[]
     */
    private $metadataInstances = [];

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $metadata
     */
    public function __construct(ObjectManagerInterface $objectManager, $metadata = [])
    {
        $this->objectManager = $objectManager;
        $this->metadata = $metadata;
    }

    /**
     * Retrieves metadata for engine code
     *
     * @param string $engineCode
     * @return EngineMetadataInterface
     * @throws \Exception
     */
    public function getMetadata($engineCode)
    {
        if (!isset($this->metadataInstances[$engineCode])) {
            if (!isset($this->metadata[$engineCode])) {
                throw new \Exception(sprintf('Unknown subscription engine metadata: %s requested', $engineCode));
            }
            $this->metadataInstances[$engineCode] = $this->objectManager->create(
                EngineMetadataInterface::class,
                ['data' => $this->metadata[$engineCode]]
            );
        }
        return $this->metadataInstances[$engineCode];
    }

    /**
     * Retrieves all engine codes
     *
     * @return array
     */
    public function getEnginesCodes()
    {
        return array_keys($this->metadata);
    }
}
