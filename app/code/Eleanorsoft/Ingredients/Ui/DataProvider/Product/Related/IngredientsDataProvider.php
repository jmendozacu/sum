<?php

namespace Eleanorsoft\Ingredients\Ui\DataProvider\Product\Related;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;
use Eleanorsoft\Ingredients\Model\Ingredients;

/**
 * Class IngredientsDataProvider
 */
class IngredientsDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc
     */
    protected function getLinkType()
    {
        return 'ingredients';
    }

    public function getCollection()
    {
        /** @var Collection $collection */
        $collection = parent::getCollection();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $ingredients = $objectManager->get('Eleanorsoft\Ingredients\Model\Ingredients');

        $collection->addAttributeToSelect(['status', 'attribute_set_id']);
        $collection->addAttributeToFilter('attribute_set_id',
            $ingredients->getAttributeSetId()
        );

        if ($this->getStore()) {
            $collection->setStore($this->getStore());
        }

        if (!$this->getProduct()) {
            return $collection;
        }

        $collection->addAttributeToFilter(
            $collection->getIdFieldName(),
            ['nin' => [$this->getProduct()->getId()]]
        );

        return $this->addCollectionFilters($collection);
    }
}
