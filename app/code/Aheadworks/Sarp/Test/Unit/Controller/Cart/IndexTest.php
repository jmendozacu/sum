<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Controller\Cart;

use Aheadworks\Sarp\Controller\Cart\Index;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Test for \Aheadworks\Sarp\Controller\Cart\Index
 */
class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Index
     */
    private $action;

    /**
     * @var PageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resultPageFactoryMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->resultPageFactoryMock = $this->getMock(PageFactory::class, ['create'], [], '', false);
        $this->action = $objectManager->getObject(
            Index::class,
            ['resultPageFactory' => $this->resultPageFactoryMock]
        );
    }

    public function testExecute()
    {
        $resultPageMock = $this->getMock(Page::class, ['getConfig'], [], '', false);
        $pageConfigMock = $this->getMock(PageConfig::class, ['getTitle'], [], '', false);
        $titleMock = $this->getMock(Title::class, ['set'], [], '', false);

        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($resultPageMock);
        $resultPageMock->expects($this->once())
            ->method('getConfig')
            ->willReturn($pageConfigMock);
        $pageConfigMock->expects($this->once())
            ->method('getTitle')
            ->willReturn($titleMock);
        $titleMock->expects($this->once())
            ->method('set')
            ->with('Subscription Cart');

        $this->assertEquals($resultPageMock, $this->action->execute());
    }
}
