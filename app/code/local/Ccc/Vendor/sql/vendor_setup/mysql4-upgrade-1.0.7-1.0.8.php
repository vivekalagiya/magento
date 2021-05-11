<?php

$installer = $this;
$installer->startSetup();


$installer->run("
    ALTER TABLE `vendor_product_attribute_group` ADD UNIQUE( `attribute_group_id`, `entity_id`)
");

$installer->endSetup();
