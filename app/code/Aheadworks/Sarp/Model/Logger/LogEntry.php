<?php
namespace Aheadworks\Sarp\Model\Logger;

use Aheadworks\Sarp\Model\ResourceModel\Logger\LogEntry as LogEntryResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class LogEntry
 * @package Aheadworks\Sarp\Model\Logger
 */
class LogEntry extends AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(LogEntryResource::class);
    }
}
