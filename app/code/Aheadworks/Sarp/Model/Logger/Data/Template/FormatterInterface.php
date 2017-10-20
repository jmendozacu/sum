<?php
namespace Aheadworks\Sarp\Model\Logger\Data\Template;

/**
 * Interface FormatterInterface
 * @package Aheadworks\Sarp\Model\Logger\Data\Template
 */
interface FormatterInterface
{
    /**
     * Format value
     *
     * @param string $data
     * @return string
     */
    public function format($data);
}
