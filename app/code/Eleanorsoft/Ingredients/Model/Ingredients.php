<?php

namespace Eleanorsoft\Ingredients\Model;

class Ingredients extends \Magento\Framework\Model\AbstractModel
{
    protected $_eavConfig;
    protected $_eavAttribute;
    protected $_attributeSetCollection;
    protected $_productCollectionFactory;

    const INGREDIENTS_ATTR_SET_LABEL    = 'Ingredients';
    const INGREDIENTS_ATTR_SET_CODE     = 'ingredients_category';

    public function __construct(
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $attributeSetCollection
    ) {
        $this->_eavConfig                   = $eavConfig;
        $this->_eavAttribute                = $eavAttribute;
        $this->_attributeSetCollection      = $attributeSetCollection;
        $this->_productCollectionFactory    = $productCollectionFactory;
    }

    public function getAttributeId()
    {
        return $this->_eavAttribute->getIdByCode('catalog_product', self::INGREDIENTS_ATTR_SET_CODE);
    }

    public function getAttributeSetId()
    {
        return $this->_attributeSetCollection->create()
            ->addFieldToSelect('attribute_set_id')
            ->addFieldToFilter('attribute_set_name', self::INGREDIENTS_ATTR_SET_LABEL)
            ->getFirstItem()
            ->getAttributeSetId();
    }

    public function getGroupedIngredients()
    {
        $groupedIngredients     = [];
        $_products              = $this->getIngredientsCollection();
        $_attributeSetValues    = $this->getAttributeSetValues();

        foreach ($_products as $product)
        {
            foreach ($_attributeSetValues as $attributeSetValue) {
                if (in_array(
                    $attributeSetValue, $product->getAttributeText(self::INGREDIENTS_ATTR_SET_CODE)
                )) {
                    $groupedIngredients[$attributeSetValue][] = $product;
                }
            }
        }

        return $groupedIngredients;
    }

    private function getIngredientsCollection()
    {
        return $this->_productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('attribute_set_id',
                $this->getAttributeSetId()
            );
    }

    private function getAttributeSetValues()
    {
        $options = $this->_eavConfig
            ->getAttribute('catalog_product', self::INGREDIENTS_ATTR_SET_CODE)
            ->getSource()
            ->getAllOptions();

        foreach ($options as $option) {
            if ($option['label'] != ' ') {
                $labels[] = $option['label'];
            }
        }

        return $labels;
    }
}
