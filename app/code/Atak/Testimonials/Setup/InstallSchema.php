<?php

namespace Atak\Testimonials\Setup;

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
        $tableNameItem = $installer->getTable('atak_testimonials');
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
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Created At'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Name'
                )
                ->addColumn(
                    'subtitle',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Sub-Title'
                )
                ->addColumn(
                    'text',
                    Table::TYPE_TEXT,
                    1000,
                    ['nullable' => false, 'default' => ''],
                    'Text'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Image'
                )
                ->addColumn(
                    'order_number',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '100'],
                    'Order'
                )
                ->addColumn(
                    'is_enabled',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Is Enabled'
                )
                ->setComment('Testimonials')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}