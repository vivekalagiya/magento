<?php

$this->startSetup();

$query = "ALTER TABLE `vendor_product` ADD COLUMN `vendor_id` INT(11)";

$this->run($query);

$this->endSetup();