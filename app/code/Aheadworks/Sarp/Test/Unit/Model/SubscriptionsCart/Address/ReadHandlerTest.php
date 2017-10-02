<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Test\Unit\Model\SubscriptionsCart\Address;

use Aheadworks\Sarp\Api\Data\SubscriptionsCartInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterface;
use Aheadworks\Sarp\Api\Data\SubscriptionsCartAddressInterfaceFactory;
use Aheadworks\Sarp\Model\SubscriptionsCart\Address\ReadHandler;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\EntityMetadataInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Sarp\Model\SubscriptionsCart\Address\ReadHandler
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ReadHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReadHandler
     */
    private $readHandler;

    /**
     * @var ResourceConnection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceConnectionMock;

    /**
     * @var MetadataPool|\PHPUnit_Framework_MockObject_MockObject
     */
    private $metadataPoolMock;

    /**
     * @var EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManagerMock;

    /**
     * @var SubscriptionsCartAddressInterfaceFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $addressFactoryMock;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->resourceConnectionMock = $this->getMock(
            ResourceConnection::class,
            ['getConnectionByName', 'getTableName'],
            [],
            '',
            false
        );
        $this->metadataPoolMock = $this->getMock(MetadataPool::class, ['getMetadata'], [], '', false);
        $this->entityManagerMock = $this->getMock(EntityManager::class, ['load'], [], '', false);
        $this->addressFactoryMock = $this->getMock(
            SubscriptionsCartAddressInterfaceFactory::class,
            ['create'],
            [],
            '',
            false
        );
        $this->readHandler = $objectManager->getObject(
            ReadHandler::class,
            [
                'resourceConnection' => $this->resourceConnectionMock,
                'metadataPool' => $this->metadataPoolMock,
                'entityManager' => $this->entityManagerMock,
                'addressFactory' => $this->addressFactoryMock
            ]
        );
    }

    public function testExecute()
    {
        $cartId = 1;
        $addressId = 2;
        $connectionName = 'default';
        $tableName = 'aw_sarp_subscriptions_cart_address';

        $cartMock = $this->getMockForAbstractClass(SubscriptionsCartInterface::class);
        $addressMock = $this->getMockForAbstractClass(SubscriptionsCartAddressInterface::class);
        $metadataMock = $this->getMockForAbstractClass(EntityMetadataInterface::class);
        $connectionMock = $this->getMockForAbstractClass(AdapterInterface::class);
        $selectMock = $this->getMock(Select::class, ['from', 'where'], [], '', false);

        $cartMock->expects($this->once())
            ->method('getCartId')
            ->willReturn($cartId);
        $this->metadataPoolMock->expects($this->once())
            ->method('getMetadata')
            ->with(SubscriptionsCartAddressInterface::class)
            ->willReturn($metadataMock);
        $metadataMock->expects($this->once())
            ->method('getEntityConnectionName')
            ->willReturn($connectionName);
        $this->resourceConnectionMock->expects($this->once())
            ->method('getConnectionByName')
            ->with($connectionName)
            ->willReturn($connectionMock);
        $connectionMock->expects($this->once())
            ->method('select')
            ->willReturn($selectMock);
        $this->resourceConnectionMock->expects($this->once())
            ->method('getTableName')
            ->willReturnArgument(0);
        $selectMock->expects($this->once())
            ->method('from')
            ->with($tableName, 'address_id')
            ->willReturnSelf();
        $selectMock->expects($this->once())
            ->method('where')
            ->with('cart_id = :id')
            ->willReturnSelf();
        $connectionMock->expects($this->once())
            ->method('fetchCol')
            ->with($selectMock, ['id' => $cartId])
            ->willReturn([$addressId]);
        $this->addressFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($addressMock);
        $this->entityManagerMock->expects($this->once())
            ->method('load')
            ->with($addressMock, $addressId);
        $cartMock->expects($this->once())
            ->method('setAddresses')
            ->with([$addressMock]);

        $this->assertEquals($cartMock, $this->readHandler->execute($cartMock));
    }
}
