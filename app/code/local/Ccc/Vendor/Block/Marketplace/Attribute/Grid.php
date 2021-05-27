<?php

class Ccc_Vendor_Block_Marketplace_Attribute_Grid extends Mage_Core_Block_Template
{
    public function getAddUrl()
    {
        return $url = $this->getUrl('*/*/new');
    }

    public function getEditUrl()
    {
        return $url = $this->getUrl('*/*/edit');
    }

    public function getAttributes()
    {
        $vendorId = Mage::getSingleton('vendor/session')->getId();
        $collection = Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId.'_%'));
        // echo '<pre>';
        // print_r($collection->getData());die;
            return $collection;
    }
}
