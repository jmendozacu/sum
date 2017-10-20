<?php
namespace Aheadworks\Sarp\Test\Unit\Model\Product\Type;

use Aheadworks\Sarp\Model\Product\Type\Restrictions;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\Product\Type\Restrictions
 */
class RestrictionsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    private $productTypes = ['simple', 'bundle'];

    /**
     * @var Restrictions
     */
    private $restrictions;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->restrictions = $objectManager->getObject(
            Restrictions::class,
            ['supportedProductTypes' => $this->productTypes]
        );
    }

    public function testGetSupportedProductTypes()
    {
        $this->assertEquals($this->productTypes, $this->restrictions->getSupportedProductTypes());
    }
}
