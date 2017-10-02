<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Model\SubscriptionEngine;

use Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterface;
use Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsInterfaceFactory;
use Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsPool;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\SubscriptionEngine\RestrictionsPool
 */
class RestrictionsPoolTest extends \PHPUnit_Framework_TestCase
{
    const ENGINE_CODE = 'engine_code';

    /**
     * @var array
     */
    private $engineRestrictions = ['fieldName' => 'fieldValue'];

    /**
     * @var RestrictionsPool
     */
    private $restrictionsPool;

    /**
     * @var RestrictionsInterfaceFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $restrictionsFactoryMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->restrictionsFactoryMock = $this->getMock(
            RestrictionsInterfaceFactory::class,
            ['create'],
            [],
            '',
            false
        );
        $this->restrictionsPool = $objectManager->getObject(
            RestrictionsPool::class,
            [
                'restrictionsFactory' => $this->restrictionsFactoryMock,
                'restrictions' => [self::ENGINE_CODE => $this->engineRestrictions]
            ]
        );
    }

    public function testGetRestrictions()
    {
        $restrictionsMock = $this->getMockForAbstractClass(RestrictionsInterface::class);
        $this->restrictionsFactoryMock->expects($this->once())
            ->method('create')
            ->with(['data' => $this->engineRestrictions])
            ->willReturn($restrictionsMock);
        $this->assertEquals($restrictionsMock, $this->restrictionsPool->getRestrictions(self::ENGINE_CODE));
    }

    public function testGetRestrictionsCaching()
    {
        $restrictionsMock = $this->getMockForAbstractClass(RestrictionsInterface::class);
        $this->restrictionsFactoryMock->expects($this->once())
            ->method('create')
            ->with(['data' => $this->engineRestrictions])
            ->willReturn($restrictionsMock);
        $this->restrictionsPool->getRestrictions(self::ENGINE_CODE);
        $this->restrictionsPool->getRestrictions(self::ENGINE_CODE);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown subscription engine: nonexistent_engine_code requested
     */
    public function testGetRestrictionsExceptionWrongEngineCode()
    {
        $this->restrictionsPool->getRestrictions('nonexistent_engine_code');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Restrictions instance engine_code does not implement required interface.
     */
    public function testGetRestrictionsExceptionWrongRestrictionsInstance()
    {
        $restrictionsClassName = 'WrongRestrictionsClassName';
        $restrictionsMock = $this->getMock($restrictionsClassName);
        $this->restrictionsFactoryMock->expects($this->once())
            ->method('create')
            ->with(['data' => $this->engineRestrictions])
            ->willReturn($restrictionsMock);
        $this->restrictionsPool->getRestrictions(self::ENGINE_CODE);
    }
}
