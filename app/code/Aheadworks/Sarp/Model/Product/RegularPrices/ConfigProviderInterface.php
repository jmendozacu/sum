<?php
namespace Aheadworks\Sarp\Model\Product\RegularPrices;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;

/**
 * Interface ConfigProviderInterface
 * @package Aheadworks\Sarp\Model\Product\RegularPrices
 */
interface ConfigProviderInterface
{
    /**
     * Get options config
     *
     * @param ProductInterface|Product $product
     * @return array
     */
    public function getOptionsConfig($product);

    /**
     * Get product price without options
     *
     * @param ProductInterface|Product $product
     * @return float
     */
    public function getPriceWithoutOptions($product);
}
