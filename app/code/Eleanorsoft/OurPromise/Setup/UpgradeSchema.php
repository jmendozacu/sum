<?php

namespace Eleanorsoft\OurPromise\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $tableName = $setup->getTable('eleanorsoft_ourpromise');

            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $installer->getConnection()->addColumn(
                    $tableName,
                    'slug',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'comment' => 'Slug',
                    ]
                );
                $installer->getConnection()->addIndex(
                    $tableName,
                    $installer->getIdxName(
                        $tableName,
                        ['slug'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['slug'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                );
            }
        }

        $installer->endSetup();
    }
}