<?php
namespace Aheadworks\Sarp\Ui\Component\Listing\Column;

/**
 * Class CustomerName
 * @package Aheadworks\Sarp\Ui\Component\Listing\Column
 */
class CustomerName extends Link
{
    /**
     * {@inheritdoc}
     */
    protected function isLink(array $item)
    {
        return (bool)$item['customer_id'];
    }
}
