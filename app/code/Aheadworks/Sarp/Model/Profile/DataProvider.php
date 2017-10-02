<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Sarp\Model\Profile;

use Aheadworks\Sarp\Model\ResourceModel\Profile\Collection;
use Aheadworks\Sarp\Model\ResourceModel\Profile\CollectionFactory;
use Aheadworks\Sarp\Model\Profile;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Aheadworks\Sarp\Model\Profile
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $subscriptionPlanCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $subscriptionPlanCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $subscriptionPlanCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $profile Profile */
        foreach ($items as $profile) {
            $this->loadedData[$profile->getProfileId()] = $profile->getData();
        }

        $data = $this->dataPersistor->get('aw_profile');
        if (!empty($data)) {
            $profile = $this->collection->getNewEmptyItem();
            $profile->setData($data);
            $this->loadedData[$profile->getProfileId()] = $profile->getData();
            $this->dataPersistor->clear('aw_profile');
        }

        return $this->loadedData;
    }
}
