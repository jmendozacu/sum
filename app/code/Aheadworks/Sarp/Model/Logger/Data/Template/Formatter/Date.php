<?php
namespace Aheadworks\Sarp\Model\Logger\Data\Template\Formatter;

use Aheadworks\Sarp\Model\Logger\Data\Template\FormatterInterface;

/**
 * Class Date
 * @package Aheadworks\Sarp\Model\Logger\Data\Template\Formatter
 */
class Date implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format($data)
    {
        $date = new \DateTime($data);
        return $date->format('M d, Y');
    }
}
