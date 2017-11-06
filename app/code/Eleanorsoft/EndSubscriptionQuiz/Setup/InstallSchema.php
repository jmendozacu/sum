<?php

namespace Eleanorsoft\EndSubscriptionQuiz\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();

        $tableName = $setup->getTable('aw_sarp_profile');

        if ($connection->isTableExists($tableName)) {
            $connection->addColumn($tableName, 'erst_reason', [
                'nullable'  => true,
                'comment'   => 'End Subscription Reason',
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            ]);
        }

        $setup->endSetup();
    }
}
