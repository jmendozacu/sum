<?php
namespace Aheadworks\Sarp\Model\Logger\Data\Template;

use Magento\Framework\Filter\Template as TemplateFilter;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class FilterProvider
 * @package Aheadworks\Sarp\Model\Logger\Data\Template
 */
class FilterProvider
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $filterClassName;

    /**
     * @var Filter
     */
    private $filterInstance;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $filterClassName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $filterClassName = Filter::class
    ) {
        $this->objectManager = $objectManager;
        $this->filterClassName = $filterClassName;
    }

    /**
     * Retrieves filter instance
     *
     * @return Filter
     * @throws \Exception
     */
    public function getFilter()
    {
        if (!$this->filterInstance) {
            $filterInstance = $this->objectManager->create($this->filterClassName);
            if (!$filterInstance instanceof TemplateFilter) {
                throw new \Exception(
                    'Template filter ' . $this->filterClassName . ' does not implement required interface.'
                );
            }
            $this->filterInstance = $filterInstance;
        }
        return $this->filterInstance;
    }
}
