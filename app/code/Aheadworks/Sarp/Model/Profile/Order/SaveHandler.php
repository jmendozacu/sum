<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\Profile\Order;

use Aheadworks\Sarp\Api\Data\ProfileOrderInterface;
use Aheadworks\Sarp\Api\Data\ProfileOrderInterfaceFactory;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class SaveHandler
 * @package Aheadworks\Sarp\Model\Profile\Order
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProfileOrderInterfaceFactory
     */
    private $profileOrderFactory;

    /**
     * @param EntityManager $entityManager
     * @param ProfileOrderInterfaceFactory $profileOrderFactory
     */
    public function __construct(
        EntityManager $entityManager,
        ProfileOrderInterfaceFactory $profileOrderFactory
    ) {
        $this->entityManager = $entityManager;
        $this->profileOrderFactory = $profileOrderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($entity, $arguments = [])
    {
        if (isset($arguments['order_id']) && $arguments['order_id']) {
            /** @var ProfileOrderInterface $profileOrder */
            $profileOrder = $this->profileOrderFactory->create();
            $profileOrder
                ->setProfileId($entity->getProfileId())
                ->setOrderId($arguments['order_id']);
            try {
                $this->entityManager->save($profileOrder);
            } catch (\Exception $e) {
                throw new CouldNotSaveException(__('Could not save recurring profile.'));
            }
        }
        return $entity;
    }
}
