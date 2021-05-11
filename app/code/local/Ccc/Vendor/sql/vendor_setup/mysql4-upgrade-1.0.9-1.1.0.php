<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('vendor/product_request'))
    ->addColumn('request_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'identity' => true,
        'primary' => true,
    ), 'Request Id')
    ->addColumn('vendor_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'vendor ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Product ID')
    ->addColumn('catalog_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => true,
    ), 'Catalog Product ID')
    ->addColumn('request_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Request Type')
    ->addColumn('approve_status', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Approve Status')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Created Time')
    ->addColumn('approved_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Approved Time')

    ->addForeignKey(
        $installer->getFkName(
            'vendor/product_request',
            'vendor_id',
            'vendor/vendor',
            'entity_id'
        ),
        'vendor_id',
        $installer->getTable('vendor/vendor'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )

    // ->addForeignKey(
    //     $installer->getFkName(
    //         'vendor/product_request',
    //         'product_id',
    //         'vendor/vendor_product',
    //         'entity_id'
    //     ),
    //     'product_id',
    //     $installer->getTable('vendor/vendor_product'),
    //     'entity_id',
    //     Varien_Db_Ddl_Table::ACTION_CASCADE,
    //     Varien_Db_Ddl_Table::ACTION_CASCADE
    // )

    ->addForeignKey(
        $installer->getFkName(
            'vendor/product_request',
            'catalog_product_id',
            'catalog/product',
            'entity_id'
        ),
        'catalog_product_id',
        $installer->getTable('catalog/product'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

$installer->getConnection()->createTable($table);

$installer->endSetup();
