<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Model\SubscriptionsCart\Item;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartItemInterface;
use Aheadworks\Sarp\Model\SubscriptionsCart\Item\Validator;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\SubscriptionsCart\Item\Validator
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var StockStateInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $stockStateMock;

    /**
     * @var ProductRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $productRepositoryMock;

    /**
     * @var array
     */
    private $itemData = [
        'getName' => 'Item name',
        'getQty' => 1,
        'getBuyRequest' => 'a:1:{s:10:"product_id";s:1:"2";}',
        'getProductId' => 2,

    ];

    /**
     * Init mocks for tests
     */
    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->stockStateMock = $this->getMockForAbstractClass(StockStateInterface::class);
        $this->productRepositoryMock = $this->getMockForAbstractClass(ProductRepositoryInterface::class);

        $this->validator = $objectManager->getObject(
            Validator::class,
            [
                'stockState' => $this->stockStateMock,
                'productRepository' => $this->productRepositoryMock
            ]
        );
    }

    /**
     * @param SubscriptionsCartItemInterface|\PHPUnit_Framework_MockObject_MockObject $itemMock
     * @param bool $expectedQtyCheck
     * @param bool $expectedResult
     * @param array $expectedMessages
     * @dataProvider isValidDataProvider
     */
    public function testIsValid($itemMock, $expectedQtyCheck, $expectedResult, $expectedMessages)
    {
        $this->stockStateMock->expects($this->any())
            ->method('checkQty')
            ->willReturn($expectedQtyCheck);
        $productMock = $this->getMockForAbstractClass(ProductInterface::class);
        $productMock->expects($this->any())
            ->method('getId')
            ->willReturn($this->itemData['getProductId']);
        $productMock->expects($this->any())
            ->method('getTypeId')
            ->willReturn('simple');
        $this->productRepositoryMock->expects($this->any())
            ->method('getById')
            ->with($this->itemData['getProductId'])
            ->willReturn($productMock);

        $this->assertEquals($expectedResult, $this->validator->isValid($itemMock));
        $this->assertEquals($expectedMessages, $this->validator->getMessages());
    }

    /**
     * Create cart item mock and optionally modify getter result
     *
     * @param string|null $methodModify
     * @param mixed|null $valueModify
     * @return SubscriptionsCartItemInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createItemMock($methodModify = null, $valueModify = null)
    {
        /** @var SubscriptionsCartItemInterface|\PHPUnit_Framework_MockObject_MockObject $itemMock */
        $itemMock = $this->getMockForAbstractClass(SubscriptionsCartItemInterface::class);
        foreach ($this->itemData as $method => $value) {
            if ($method != $methodModify) {
                $itemMock->expects($this->any())
                    ->method($method)
                    ->willReturn($value);
            } else {
                $itemMock->expects($this->any())
                    ->method($methodModify)
                    ->willReturn($valueModify);
            }
        }
        return $itemMock;
    }

    /**
     * @return array
     */
    public function isValidDataProvider()
    {
        return [
            'correct data' => [$this->createItemMock(), true, true, []],
            'missing name' => [
                $this->createItemMock('getName', null),
                true,
                false,
                ['Name is required.']
            ],
            'missing qty' => [
                $this->createItemMock('getQty', null),
                true,
                false,
                ['Qty is required.']
            ],
            'incorrect qty' => [
                $this->createItemMock('getQty', '4a'),
                true,
                false,
                ['Qty is incorrect.']
            ],
            'missing buy request' => [
                $this->createItemMock('getBuyRequest', null),
                true,
                false,
                ['Buy request is required.']
            ],
            'incorrect stock' => [
                $this->createItemMock(),
                false,
                false,
                ['Such amount could not be ordered.']
            ]
        ];
    }
}
