<?php

$this->startSetup();

$this->addEntityType(Ccc_Browse_Model_Resource_Browse::ENTITY, [
    'entity_model'                => 'browse/browse',
    'attribute_model'             => 'browse/attribute',
    'table'                       => 'browse/browse',
    'increment_per_store'         => '0',
    'additional_attribute_table'  => 'browse/eav_attribute',
    'entity_attribute_collection' => 'browse/browse_attribute_collection',
]);

$this->createEntityTables('browse');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('browse', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'browse'");

$this->endSetup();
