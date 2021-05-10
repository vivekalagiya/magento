<?php

$install = $this;
$install->startSetup();

$table = $install->getConnection()
    ->newTable($install->getTable('ccc_custom/data'))
    ->addColumn(
        'Custom_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ),
        'Id'
    )
    ->addColumn(
        'first_name',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        null,
        array(
            'nullable' => false,
            'length' => 255
        ),
        'first name'
    )
    ->addColumn(
        'last_name',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        null,
        array(
            'nullable' => false,
            'length' => 255
        ),
        'last name'
    );
$install->getConnection()->createTable($table);
$install->endSetUp();
