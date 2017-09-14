<?php

namespace Eleanorsoft\OurPromise\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Get atak_lookbook_item table
        $tableNameItem = $installer->getTable('eleanorsoft_ourpromise');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableNameItem) != true) {
            // Create atak_lookbook_item table
            $table = $installer->getConnection()
                ->newTable($tableNameItem)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Title'
                )   
                ->addColumn(
                    'background_image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Background Image'
                )
                ->addColumn(
                    'icon',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Icon'
                )
                ->addColumn(
                    'short_description',
                    Table::TYPE_TEXT,
                    1000,
                    ['nullable' => false, 'default' => ''],
                    'Short Description'
                )
                ->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    1000,
                    ['nullable' => false, 'default' => ''],
                    'Content'
                )
                ->addColumn(
                    'sort_order',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '100'],
                    'Sort Order'
                )
                ->addColumn(
                    'is_active',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Is Active'
                )
                ->setComment('promises')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}