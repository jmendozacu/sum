<?php
namespace Aheadworks\Sarp\Test\Unit\Model\Product\Attribute\Source;

use Aheadworks\Sarp\Model\Product\Attribute\Source\SubscriptionType as SubscriptionTypeSource;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\Product\Attribute\Source\SubscriptionType
 */
class SubscriptionTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var SubscriptionTypeSource
     */
    private $source;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->source = $objectManager->getObject(SubscriptionTypeSource::class);
    }

    public function testGetAllOptions()
    {
        $this->assertTrue(is_array($this->source->getAllOptions()));
    }
}
