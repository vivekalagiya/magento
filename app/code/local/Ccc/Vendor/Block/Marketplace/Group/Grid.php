<?php

class Ccc_Vendor_Block_Marketplace_Group_Grid extends Mage_Core_Block_Template
{   
    public function getAttributeGroups()
    {
        $vendorId = Mage::getSingleton('vendor/session')->getId();
        return $attributes = Mage::getResourceModel('vendor/Product_Attribute_Group_collection')
            ->addFieldToFilter('entity_id', array('eq' => $vendorId));
        // echo '<pre>';
        // print_r($attributes);
        // die;
    }

    public function getEditUrl()
    {
        return $this->getUrl('*/*/edit', ['group_id' => $this->getRequest()->getParam('group_id')]);
    }
    
}   
