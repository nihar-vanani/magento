<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('product/product'))
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Product ID')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Category ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Name')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Name')
    ->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,2', array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0.00',
        ), 'Price')
    ->addColumn('quantity', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Quantity')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, 1, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Status')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Creation Time')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Update Time')
    ->addIndex(
        $installer->getIdxName(
            array('product/product', 'varchar'),
            array('sku'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('sku'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey(
        $installer->getFkName(
            array('product/product', 'int'),
            'category_id',
            'product/product',
            'category_id'
        ),
        'category_id', $installer->getTable('category/category'), 'category_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Process Group Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();