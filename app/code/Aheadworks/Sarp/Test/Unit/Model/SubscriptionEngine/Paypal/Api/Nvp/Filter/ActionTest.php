<?php
namespace Aheadworks\Sarp\Test\Unit\Model\SubscriptionEngine\Paypal\Api\Nvp\Filter;

use Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Api\Nvp\Filter\Action as ActionFilter;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\SubscriptionEngine\Paypal\Api\Nvp\Filter\Action
 */
class ActionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ActionFilter
     */
    private $filter;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->filter = $objectManager->getObject(ActionFilter::class);
    }

    /**
     * @param string $inputValue
     * @param string $outputValue
     * @dataProvider filterDataProvider
     */
    public function testFilter($inputValue, $outputValue)
    {
        $this->assertEquals($outputValue, $this->filter->filter($inputValue));
    }

    /**
     * @return array
     */
    public function filterDataProvider()
    {
        return [
            ['cancel', 'Cancel'],
            ['suspend', 'Suspend'],
            ['activate', 'Reactivate']
        ];
    }
}
