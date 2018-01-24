<?php

namespace Nans\Faq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Nans\Faq\Helper\Constants;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $this->_createCategoryTable($setup);
        $this->_createQuestionTable($setup);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function _createCategoryTable($setup)
    {
        $tableName = $setup->getTable(Constants::DB_PREFIX . 'faq_category');

        if ($setup->tableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()->newTable($tableName);
        $this->_addPrimaryIdColumn($table, 'category_id');
        $this->_addTitleColumn($table);
        $this->_addStatusColumn($table);
        $this->_addStoreIdsColumn($table);
        $this->_addSortOrderColumn($table);
        $this->_addTimeColumns($table);
        $table->setComment('FAQ Category');
        $setup->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function _createQuestionTable($setup)
    {
        $tableName = $setup->getTable(Constants::DB_PREFIX . 'faq_question');
        $categoryTable = $setup->getTable(Constants::DB_PREFIX . 'faq_category');

        if ($setup->tableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()->newTable($tableName);
        $this->_addPrimaryIdColumn($table, 'question_id');
        $table->addColumn(
            'category_id', Table::TYPE_INTEGER, null,
            ['nullable' => false, 'unsigned' => true], 'Category ID'
        );
        $this->_addTitleColumn($table);
        $this->_addStatusColumn($table);
        $this->_addStoreIdsColumn($table);
        $this->_addSortOrderColumn($table);
        $table->addColumn(
            'content',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Content'
        )
            ->addColumn(
                'useful',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0', 'unsigned' => true],
                'Useful'
            )
            ->addColumn(
                'useless',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0', 'unsigned' => true],
                'Useless'
            );
        $this->_addForeignKey($table, $setup, 'category_id', $categoryTable, 'category_id');
        $this->_addTimeColumns($table);
        $table->setComment('FAQ Questions');
        $setup->getConnection()->createTable($table);
    }

    /**
     * @param Table $table
     */
    private function _addStatusColumn(Table &$table)
    {
        $table->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false, 'default' => 0],
            'Is enabled'
        );
    }

    /**
     * @param Table $table
     */
    private function _addTimeColumns(Table &$table)
    {
        $table->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false,
                 'default'  => Table::TIMESTAMP_INIT_UPDATE],
                'Modification Time'
            );
    }

    /**
     * @param Table $table
     * @param int   $length
     */
    private function _addTitleColumn(Table &$table, $length = 255)
    {
        $table->addColumn('title', Table::TYPE_TEXT, $length, ['nullable' => false], 'Title');
    }

    /**
     * @param Table $table
     */
    private function _addSortOrderColumn(Table &$table)
    {
        $table->addColumn(
            'sort_order',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0', 'unsigned' => true],
            'Sort Order'
        );
    }

    /**
     * @param Table $table
     * @param int   $length
     */
    private function _addStoreIdsColumn(Table &$table, int $length = 255)
    {
        $table->addColumn(
            'store_ids', Table::TYPE_TEXT, $length,
            ['nullable' => false, 'default' => '0'], 'Store Ids'
        );
    }

    /**
     * @param Table  $table
     * @param string $tile
     */
    private function _addPrimaryIdColumn(Table &$table, string $tile)
    {
        $table->addColumn(
            $tile, Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true
            ], 'ID'
        );
    }

    /**
     * @param Table                $table
     * @param SchemaSetupInterface $setup
     * @param string               $column
     * @param string               $refTable
     * @param string               $refColumn
     */
    private function _addForeignKey(
        Table &$table,
        SchemaSetupInterface $setup,
        string $column,
        string $refTable,
        string $refColumn
    ) {
        $fkName = $setup->getFkName($table->getName(), $column, $refTable, $refColumn);
        $table->addForeignKey(
            $fkName,
            $column,
            $refTable,
            $refColumn,
            Table::ACTION_CASCADE
        );
    }
}