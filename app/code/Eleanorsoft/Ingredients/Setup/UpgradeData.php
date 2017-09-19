<?php

namespace Eleanorsoft\Ingredients\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $_eavSetupFactory;
    private $_attributeSetFactory;
    private $_categorySetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->_eavSetupFactory         = $eavSetupFactory;
        $this->_attributeSetFactory     = $attributeSetFactory;
        $this->_categorySetupFactory    = $categorySetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->startSetup();

            $productLinkTable = 'catalog_product_link';
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($productLinkTable),
                    'store_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'default' => 0,
                        'comment' => 'Store Id'
                    ]
                );

            $data = [
                ['link_type_id' => \Eleanorsoft\Ingredients\Model\Catalog\Product\Link::LINK_TYPE_INGREDIENTS, 'code' => 'ingredients']
            ];

            foreach ($data as $bind) {
                $setup->getConnection()
                    ->insertForce($setup->getTable('catalog_product_link_type'), $bind);
            }

            $data = [
                [
                    'link_type_id' => \Eleanorsoft\Ingredients\Model\Catalog\Product\Link::LINK_TYPE_INGREDIENTS,
                    'product_link_attribute_code' => 'position',
                    'data_type' => 'int',
                ]
            ];

            $setup->getConnection()
                ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);

            $setup->endSetup();
        }

        if(version_compare($context->getVersion(), '1.0.2', '<')) {
            $attributeSetName   = 'Ingredients';
            $eavSetup           = $this->_eavSetupFactory->create(['setup' => $setup]);
            $categorySetup      = $this->_categorySetupFactory->create(['setup' => $setup]);


            $attributeSet   = $this->_attributeSetFactory->create();
            $entityTypeId   = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
            $data = [
                'attribute_set_name'    => $attributeSetName,
                'entity_type_id'        => $entityTypeId,
                'sort_order'            => 0,
            ];

            $attributeSet->setData($data);
            $attributeSet->validate();
            $attributeSet->save();
            $attributeSet->initFromSkeleton($attributeSetId);
            $attributeSet->save();

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'ingredients_category',
                [
                    'type' => 'varchar',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'frontend' => '',
                    'label' => 'Ingredients Category',
                    'input' => 'multiselect',
                    'class' => '',
                    'source' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => '',
                    'group' => '',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => '',
                    'attribute_set' => $attributeSetName
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.0.3', '<')) {
            $eavSetup       = $this->_eavSetupFactory->create(['setup' => $setup]);
            $categorySetup  = $this->_categorySetupFactory->create(['setup' => $setup]);
            $entityTypeId   = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $eavSetup->getAttributeSetId($entityTypeId, 'Ingredients');

            $eavSetup->addAttributeToSet($entityTypeId, $attributeSetId, 'General', 'ingredients_category', 10);
        }
    }
}