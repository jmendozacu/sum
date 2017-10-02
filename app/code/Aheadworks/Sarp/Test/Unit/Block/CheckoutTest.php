<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Block\Cart;

use Aheadworks\Sarp\Block\Checkout;
use Aheadworks\Sarp\Model\Checkout\CompositeConfigProvider;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Test for \Aheadworks\Sarp\Block\Checkout
 */
class CheckoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Checkout
     */
    private $block;

    /**
     * @var FormKey|\PHPUnit_Framework_MockObject_MockObject
     */
    private $formKeyMock;

    /**
     * @var CompositeConfigProvider|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configProviderMock;

    /**
     * @var LayoutProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $layoutProcessorMock;

    /**
     * @var StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $storeManagerMock;

    /**
     * @var array
     */
    private $jsLayout = ['components' => ['checkout' => []]];

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->formKeyMock = $this->getMock(FormKey::class, ['getFormKey'], [], '', false);
        $this->configProviderMock = $this->getMock(CompositeConfigProvider::class, ['getConfig'], [], '', false);
        $this->layoutProcessorMock = $this->getMockForAbstractClass(LayoutProcessorInterface::class);
        $this->storeManagerMock = $this->getMockForAbstractClass(StoreManagerInterface::class);
        $context = $objectManager->getObject(
            Context::class,
            ['storeManager' => $this->storeManagerMock]
        );
        $this->block = $objectManager->getObject(
            Checkout::class,
            [
                'context' => $context,
                'formKey' => $this->formKeyMock,
                'configProvider' => $this->configProviderMock,
                'layoutProcessors' => [$this->layoutProcessorMock],
                'jsLayout' => $this->jsLayout
            ]
        );
    }

    public function testGetJsLayout()
    {
        $isLayoutProcessed = array_merge_recursive(
            $this->jsLayout,
            ['components' => ['checkout' => ['new_component' => []]]]
        );
        $jsLayoutEncoded = json_encode($isLayoutProcessed);
        $this->layoutProcessorMock->expects($this->once())
            ->method('process')
            ->with($this->jsLayout)
            ->willReturn($isLayoutProcessed);
        $this->assertEquals($jsLayoutEncoded, $this->block->getJsLayout());
    }

    public function testGetFormKey()
    {
        $formKey = 'form_key_value';
        $this->formKeyMock->expects($this->once())
            ->method('getFormKey')
            ->willReturn($formKey);
        $this->assertEquals($formKey, $this->block->getFormKey());
    }

    public function testGetCheckoutConfig()
    {
        $config = ['subscriptionsCart' => []];
        $this->configProviderMock->expects($this->once())
            ->method('getConfig')
            ->willReturn($config);
        $this->assertEquals($config, $this->block->getCheckoutConfig());
    }

    public function testGetBaseUrl()
    {
        $baseUrl = 'http://localhost';
        $storeMock = $this->getMock(Store::class, ['getBaseUrl'], [], '', false);
        $this->storeManagerMock->expects($this->once())
            ->method('getStore')
            ->willReturn($storeMock);
        $storeMock->expects($this->once())
            ->method('getBaseUrl')
            ->willReturn($baseUrl);
        $this->assertEquals($baseUrl, $this->block->getBaseUrl());
    }
}
