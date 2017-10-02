<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Observer;

use Aheadworks\Sarp\Model\SubscriptionsCart\Persistor;
use Aheadworks\Sarp\Observer\ClearSessionObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Observer\ClearSessionObserver
 */
class ClearSessionObserverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClearSessionObserver
     */
    private $observer;

    /**
     * @var Persistor|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cartPersistorMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->cartPersistorMock = $this->getMock(Persistor::class, ['clear'], [], '', false);
        $this->observer = $objectManager->getObject(
            ClearSessionObserver::class,
            ['cartPersistor' => $this->cartPersistorMock]
        );
    }

    public function testExecute()
    {
        /** @var Observer|\PHPUnit_Framework_MockObject_MockObject $observerMock */
        $observerMock = $this->getMock(Observer::class, [], [], '', false);

        $this->cartPersistorMock->expects($this->once())
            ->method('clear');

        $this->observer->execute($observerMock);
    }
}
