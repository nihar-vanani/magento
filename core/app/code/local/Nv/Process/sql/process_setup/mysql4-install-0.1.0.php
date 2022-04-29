<?php

/*    $installer = $this;

    $installer->startSetup();

    $installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('process')};
    CREATE TABLE {$this->getTable('process')} (
      `process_id` int(11) unsigned NOT NULL auto_increment,
      `group_id` int(11) NOT NULL,
      `type_id` int(11) NOT NULL,
      `name` varchar(255) NOT NULL default '',
      `request_model` varchar(255) NOT NULL default '',
      `per_request_count` int(11) NOT NULL default '0',
      `request_interval` int(11) NOT NULL default '0',
      `file_name` varchar(255) NOT NULL default '',
      `created_date` varchar(255) NOT NULL default '',
      PRIMARY KEY (`process_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");



    $installer->endSetup();*/

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process_group'))
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Group ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Name')
    ->setComment('Process Group Table');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process'))
    ->addColumn('process_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Process ID')
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Group ID')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Type ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Name')
    ->addColumn('request_model', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Request Model')
    ->addColumn('file_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'File Name')
    ->addColumn('per_request_count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Per Request Count')
    ->addColumn('request_interval', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Request Interval')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Creation Time')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Update Time')
    ->addForeignKey(
        $installer->getFkName(
            array('process/process', 'int'),
            'group_id',
            'process/process',
            'group_id'
        ),
        'group_id', $installer->getTable('process/process_group'), 'group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Process Main Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process_column'))
    ->addColumn('column_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Column ID')
    ->addColumn('process_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Process ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Name')
    ->addColumn('required', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Required')
    ->addColumn('exception', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Exception')
    ->addColumn('casting_type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Casting Type')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Creation Time')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Update Time')
    ->addForeignKey(
        $installer->getFkName(
            array('process/process_column', 'int'),
            'process_id',
            'process/process_column',
            'process_id'
        ),
        'process_id', $installer->getTable('process/process'), 'process_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Process Column Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process_entry'))
    ->addColumn('entry_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entry ID')
    ->addColumn('process_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Process ID')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => "",
        ), 'Identifier')
    ->addColumn('data', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Data')
    ->addColumn('start_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Start Time')
    ->addColumn('end_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'End Time')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Creation Time')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Update Time')
    ->addForeignKey(
        $installer->getFkName(
            array('process/process_entry', 'int'),
            'process_id',
            'process/process_entry',
            'process_id'
        ),
        'process_id', $installer->getTable('process/process'), 'process_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Process Entry Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();