<?php

$this->startSetup();

$query = "ALTER TABLE `browse_decimal` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$this->getConnection()->query($query);

$query = "ALTER TABLE `browse_int` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$this->getConnection()->query($query);

$query = "ALTER TABLE `browse_text` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$this->getConnection()->query($query);

$query = "ALTER TABLE `browse_char` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$this->getConnection()->query($query);

$query = "ALTER TABLE `browse_datetime` ADD UNIQUE( `attribute_id`, `store_id`, `entity_id`)";
$this->getConnection()->query($query);

$this->endSetup();

