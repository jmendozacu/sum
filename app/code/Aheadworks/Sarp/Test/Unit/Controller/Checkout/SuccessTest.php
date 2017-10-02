<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Controller\Checkout;

use Aheadworks\Sarp\Controller\Checkout\Success;
use Aheadworks\Sarp\Model\SubscriptionsCart\Persistor;
use Aheadworks\Sarp\Model\SubscriptionsCart\SuccessValidator;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Test for \Aheadworks\Sarp\Controller\Checkout\Success
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SuccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Success
     */
    private $action;

    /**
     * @var PageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resultPageFactoryMock;

    /**
     * @var RedirectFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resultRedirectFactoryMock;

    /**
     * @var Persistor|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cartPersistorMock;

    /**
     * @var SuccessValidator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $successValidatorMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->resultPageFactoryMock = $this->getMock(PageFactory::class, ['create'], [], '', false);
        $this->resultRedirectFactoryMock = $this->getMock(RedirectFactory::class, ['create'], [], '', false);
        $this->cartPersistorMock = $this->getMock(Persistor::class, ['clear'], [], '', false);
        $this->successValidatorMock = $this->getMock(SuccessValidator::class, ['isValid'], [], '', false);
        $context = $objectManager->getObject(
            Context::class,
            ['resultRedirectFactory' => $this->resultRedirectFactoryMock]
        );
        $this->action = $objectManager->getObject(
            Success::class,
            [
                'context' => $context,
                'resultPageFactory' => $this->resultPageFactoryMock,
                'cartPersistor' => $this->cartPersistorMock,
                'successValidator' => $this->successValidatorMock
            ]
        );
    }

    public function testExecute()
    {
        $resultPageMock = $this->getMock(Page::class, [], [], '', false);

        $this->successValidatorMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);
        $this->cartPersistorMock->expects($this->once())
            ->method('clear');
        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($resultPageMock);

        $this->assertEquals($resultPageMock, $this->action->execute());
    }

    public function testExecuteInvalid()
    {
        $resultRedirectMock = $this->getMock(Redirect::class, ['setPath'], [], '', false);

        $this->successValidatorMock->expects($this->once())
            ->method('isValid')
            ->willReturn(false);
        $this->resultRedirectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($resultRedirectMock);
        $resultRedirectMock->expects($this->once())
            ->method('setPath')
            ->with('aw_sarp/cart/index');

        $this->assertEquals($resultRedirectMock, $this->action->execute());
    }
}
