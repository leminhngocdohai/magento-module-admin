<?php

namespace Aht\Product\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 *
 * @package Modulevip\Pro\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install Pro Posts table
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('aht_product_items');

        if ($setup->getConnection()->isTableExists($tableName) != true) {
            $table = $setup->getConnection()
                ->newTable($tableName)
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
                    'name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Name'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Image'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Description'
                )
                ->addColumn(
                    'featured',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false],
                    'Featured'
                )
                ->addColumn(
                    'category_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Category id'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false],
                    'Created at'
                )
                ->setComment('Aht Product Item');
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}