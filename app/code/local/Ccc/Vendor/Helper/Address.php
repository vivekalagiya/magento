<?php

class Ccc_Vendor_Helper_Address extends Mage_Core_Helper_Abstract
{

    const XML_PATH_VAT_VALIDATION_ENABLED          = 'customer/create_account/auto_group_assign';

    public function isVatValidationEnabled($store = null)
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_VAT_VALIDATION_ENABLED, $store);
    }
}
