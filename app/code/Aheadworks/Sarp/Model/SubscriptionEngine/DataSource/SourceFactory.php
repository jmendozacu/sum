<?php
namespace Aheadworks\Sarp\Model\SubscriptionEngine\DataSource;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class SourceFactory
 * @package Aheadworks\Sarp\Model\SubscriptionEngine\DataSource
 */
class SourceFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create source instance
     *
     * @param string $className
     * @return OptionSourceInterface
     */
    public function create($className)
    {
        return $this->objectManager->create($className);
    }
}
