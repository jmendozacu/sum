<?php
namespace Aheadworks\Sarp\Model\Product\Type;

/**
 * Class Restrictions
 * @package Aheadworks\Sarp\Model\Product\Type
 */
class Restrictions
{
    /**
     * @var array
     */
    private $supportedProductTypes = [];

    /**
     * @param array $supportedProductTypes
     */
    public function __construct($supportedProductTypes = [])
    {
        $this->supportedProductTypes = $supportedProductTypes;
    }

    /**
     * Get supported product types
     *
     * @return array
     */
    public function getSupportedProductTypes()
    {
        return $this->supportedProductTypes;
    }
}
