<?php

$installer = $this;
$installer->startSetup();


$installer->run("
    ALTER TABLE `vendor_eav_attribute` ADD `sort_order` int(10) unsigned NOT NULL default '0';
");

$installer->endSetup();
