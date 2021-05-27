<?php

$installer = $this;

$installer->startSetup();
$installer->updateAttribute('vendor_product','sku','backend_type', 'varchar');
$installer->endSetup();
?>

