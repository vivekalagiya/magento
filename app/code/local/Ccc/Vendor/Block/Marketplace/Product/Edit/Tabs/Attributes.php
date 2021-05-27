<?php

class Ccc_Vendor_Block_Marketplace_Product_Edit_Tabs_Attributes extends Mage_Core_Block_Template
{
    protected $optionArray = [];

    public function __construct()
    {
        $this->setTemplate('vendor/marketplace/product/edit/tabs/attributes.phtml');
    }

    public function getOptions($attributeId)
    {

        $conn = Mage::getSingleton('core/resource')->getConnection('core_write');
        $sql = "select `option_id` from `eav_attribute_option` where `attribute_id`= $attributeId";

        $optionIds = $conn->fetchAll($sql);
        if ($optionIds) {
            foreach ($optionIds as $key => $value) {
                $optionId = $value['option_id'];
                $sql = "SELECT `option_id`,`value` FROM `eav_attribute_option_value` WHERE `option_id` = $optionId";
                $options = $conn->fetchAll($sql);
                $optionArray[] = $options[0];
            }
        }
        return $optionArray;
    }
    public function getProductData()
    {
        return Mage::registry('current_product');
    }
}
