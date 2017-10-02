<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Model\SubscriptionsCart\Item;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartItemInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface;
use Aheadworks\Sarp\Model\SubscriptionsCart\Item\Converter\QuoteAddressItemsConverter;
use Aheadworks\Sarp\Model\SubscriptionsCart\Item\Converter\TaxQuoteDetailsItemsConverter;
use Aheadworks\Sarp\Model\SubscriptionsCart\Item\ConverterManager;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Quote\Model\Quote\Address\Item as QuoteAddressItem;
use Magento\Tax\Api\Data\QuoteDetailsItemInterface;

/**
 * Test for \Aheadworks\Sarp\Model\SubscriptionsCart\Item\ConverterManager
 */
class ConverterManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConverterManager
     */
    private $converterManager;

    /**
     * @var QuoteAddressItemsConverter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $toQuoteAddressItemsConverterMock;

    /**
     * @var TaxQuoteDetailsItemsConverter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $toTaxQuoteDetailsItemsConverterMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->toQuoteAddressItemsConverterMock = $this->getMock(
            QuoteAddressItemsConverter::class,
            ['convert'],
            [],
            '',
            false
        );
        $this->toTaxQuoteDetailsItemsConverterMock = $this->getMock(
            TaxQuoteDetailsItemsConverter::class,
            ['convert'],
            [],
            '',
            false
        );
        $this->converterManager = $objectManager->getObject(
            ConverterManager::class,
            [
                'toQuoteAddressItemsConverter' => $this->toQuoteAddressItemsConverterMock,
                'toTaxQuoteDetailsItemsConverter' => $this->toTaxQuoteDetailsItemsConverterMock
            ]
        );
    }

    public function testToQuoteAddressItems()
    {
        $useTrialPrice = false;
        /** @var SubscriptionsCartItemInterface|\PHPUnit_Framework_MockObject_MockObject $itemMock */
        $itemMock = $this->getMockForAbstractClass(SubscriptionsCartItemInterface::class);
        /** @var SubscriptionsCartAddressInterface|\PHPUnit_Framework_MockObject_MockObject $addressMock */
        $addressMock = $this->getMockForAbstractClass(SubscriptionsCartAddressInterface::class);
        $quoteAddressItemMock = $this->getMock(QuoteAddressItem::class, [], [], '', false);
        $this->toQuoteAddressItemsConverterMock->expects($this->once())
            ->method('convert')
            ->with([$itemMock], $addressMock, $useTrialPrice)
            ->willReturn([$quoteAddressItemMock]);
        $this->assertEquals(
            [$quoteAddressItemMock],
            $this->converterManager->toQuoteAddressItems([$itemMock], $addressMock, $useTrialPrice)
        );
    }

    public function testToTaxQuoteDetailsItems()
    {
        $isPriceIncludesTax = false;
        $isUseBaseCurrency = true;
        $isTrial = false;
        /** @var SubscriptionsCartItemInterface|\PHPUnit_Framework_MockObject_MockObject $itemMock */
        $itemMock = $this->getMockForAbstractClass(SubscriptionsCartItemInterface::class);
        $quoteDetailsItemMock = $this->getMockForAbstractClass(QuoteDetailsItemInterface::class);
        $this->toTaxQuoteDetailsItemsConverterMock->expects($this->once())
            ->method('convert')
            ->with([$itemMock], $isPriceIncludesTax, $isUseBaseCurrency, $isTrial)
            ->willReturn([$quoteDetailsItemMock]);
        $this->assertEquals(
            [$quoteDetailsItemMock],
            $this->converterManager->toTaxQuoteDetailsItems(
                [$itemMock],
                $isPriceIncludesTax,
                $isUseBaseCurrency,
                $isTrial
            )
        );
    }
}
