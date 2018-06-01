<?php

namespace Tickles\Supersales\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     *
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface   $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     *
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Zend_Db_Exception
     */
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();


        $tableName = 'supersale';
        if (!$installer->tableExists($tableName)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName)
            )
            ->addColumn(
                $tableName.'_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Sale product-id'
            )
            ->addColumn(
                'is_enabled',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                1,
                ['nullable => false'],
                'Sale enabled'
            )
            ->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                [ 'nullable => false' ],
                'Sale sort order'
            )
            ->addColumn(
                'sale_identifier',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [ 'nullable => false' ],
                'Sale sort order'
            )
            ->addColumn(
                'label_text',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [ 'nullable => false' ],
                'Sale sort order'
            )
            ->addColumn(
                'start_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [ 'nullable => false' ],
                'Start-date of the sale'
            )
            ->addColumn(
                'end_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [ 'nullable => false' ],
                'End-date of the sale'
            );

            $installer->getConnection()->createTable($table);

        }



        $installer->endSetup();
    }
}