<?php

$installer = $this;


$table = $installer->getConnection()
    ->newTable($installer->getTable('browse/eav_attribute'))
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Attribute ID')
    ->addColumn('frontend_input_renderer', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Frontend Input Renderer')
    ->addColumn('is_global', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Is Global')
    ->addColumn('is_visible', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Is Visible')
    ->addColumn('is_searchable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Searchable')
    ->addColumn('is_filterable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Filterable')
    ->addColumn('is_comparable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Comparable')
    ->addColumn('is_visible_on_front', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Visible On Front')
    ->addColumn('is_html_allowed_on_front', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is HTML Allowed On Front')
    ->addColumn('is_used_for_price_rules', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Used For Price Rules')
    ->addColumn('is_filterable_in_search', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Filterable In Search')
    ->addColumn('used_in_product_listing', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Used In Product Listing')
    ->addColumn('used_for_sort_by', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Used For Sorting')
    ->addColumn('is_configurable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Is Configurable')
    ->addColumn('apply_to', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
    ), 'Apply To')
    ->addColumn('is_visible_in_advanced_search', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Visible In Advanced Search')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'default'  => '0',
    ), 'Position')
    ->addColumn('is_wysiwyg_enabled', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is WYSIWYG Enabled')
    ->addColumn('is_used_for_promo_rules', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Is Used For Promo Rules')
    ->addIndex($installer->getIdxName('browse/eav_attribute', array('used_for_sort_by')),
        array('used_for_sort_by'))
    ->addIndex($installer->getIdxName('browse/eav_attribute', array('used_in_product_listing')),
        array('used_in_product_listing'))
    ->addForeignKey($installer->getFkName('browse/eav_attribute', 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('browse EAV Attribute Table');

$query = "ALTER TABLE `browse_varchar` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$installer->getConnection()->query($query);

$installer->getConnection()->createTable($table);

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

// $setup->addAttribute(Ccc_Browse_Model_Resource_Browse::ENTITY, 'name', array(
//     'group'                      => 'General',
//     'input'                      => 'text',
//     'type'                       => 'varchar',
//     'label'                      => 'name',
//     'backend'                    => '',
//     'visible'                    => 1,
//     'required'                   => 0,
//     'user_defined'               => 1,
//     'searchable'                 => 1,
//     'filterable'                 => 0,
//     'comparable'                 => 1,
//     'visible_on_front'           => 1,
//     'visible_in_advanced_search' => 0,
//     'is_html_allowed_on_front'   => 1,
//     'global'                     => Ccc_Browse_Model_Resource_Eav_Attribute::SCOPE_STORE,

// ));

// $setup->addAttribute(Ccc_Browse_Model_Resource_Browse::ENTITY, 'sku', array(
//     'group'                      => 'General',
//     'input'                      => 'text',
//     'type'                       => 'varchar',
//     'label'                      => 'sku',
//     'backend'                    => '',
//     'visible'                    => 1,
//     'required'                   => 0,
//     'user_defined'               => 1,
//     'searchable'                 => 1,
//     'filterable'                 => 0,
//     'comparable'                 => 1,
//     'visible_on_front'           => 1,
//     'visible_in_advanced_search' => 0,
//     'is_html_allowed_on_front'   => 1,
//     'global'                     => Ccc_Browse_Model_Resource_Eav_Attribute::SCOPE_STORE,
// ));

// $setup->addAttribute(Ccc_Browse_Model_Resource_Browse::ENTITY, 'price', array(
//     'group'                      => 'General',
//     'input'                      => 'text',
//     'type'                       => 'decimal',
//     'label'                      => 'price',
//     'backend'                    => '',
//     'visible'                    => 1,
//     'required'                   => 0,
//     'user_defined'               => 1,
//     'searchable'                 => 1,
//     'filterable'                 => 0,
//     'comparable'                 => 1,
//     'visible_on_front'           => 1,
//     'visible_in_advanced_search' => 0,
//     'is_html_allowed_on_front'   => 1,
//     'global'                     => Ccc_Browse_Model_Resource_Eav_Attribute::SCOPE_STORE,
// ));

// $setup->addAttribute(Ccc_Browse_Model_Resource_Browse::ENTITY, 'quantity', array(
//     'group'                      => 'General',
//     'input'                      => 'text',
//     'type'                       => 'int',
//     'label'                      => 'quantity',
//     'frontend_class'             => 'validate-digits',
//     'backend'                    => '',
//     'visible'                    => 1,
//     'required'                   => 0,
//     'user_defined'               => 1,
//     'searchable'                 => 1,
//     'filterable'                 => 0,
//     'comparable'                 => 1,
//     'visible_on_front'           => 1,
//     'visible_in_advanced_search' => 0,
//     'is_html_allowed_on_front'   => 1,
//     'global'                     => Ccc_Browse_Model_Resource_Eav_Attribute::SCOPE_STORE,
// ));

$installer->endSetup();
