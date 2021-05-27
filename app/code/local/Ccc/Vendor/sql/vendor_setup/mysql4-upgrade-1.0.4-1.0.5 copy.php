<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('vendor/eav_attribute_website'))
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Attribute Id')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Website Id')
    ->addColumn('is_visible', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
    ), 'Is Visible')
    ->addColumn('is_required', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
    ), 'Is Required')
    ->addColumn('default_value', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(), 'Default Value')
    ->addColumn('multiline_count', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
    ), 'Multiline Count')
    ->addIndex(
        $installer->getIdxName('vendor/eav_attribute_website', array('website_id')),
        array('website_id')
    )
    ->addForeignKey(
        $installer->getFkName('vendor/eav_attribute_website', 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id',
        $installer->getTable('eav/attribute'),
        'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $installer->getFkName('vendor/eav_attribute_website', 'website_id', 'core/website', 'website_id'),
        'website_id',
        $installer->getTable('core/website'),
        'website_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Vendor Eav Attribute Website');
$installer->getConnection()->createTable($table);

$installer->endSetup();
