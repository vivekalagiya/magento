<?php

class Ccc_Vendor_Block_Marketplace_Attribute_Form extends Mage_Core_Block_Template
{
    public function getAttribute()
    {
        return Mage::registry('entity_attribute');
    }

    public function getGroups()
    {
        $vendorId = Mage::getSingleton('vendor/session')->getId();

        return $groups = Mage::getResourceModel('vendor/product_attribute_group_collection')
            ->addFieldToFilter('entity_id', array('eq' => $vendorId))->getData();
        // echo '<pre>';
        // print_r($groups);
    }

    public function getSaveUrl()
    {
        return $url = $this->getUrl('*/*/save',['attribute_id' => $this->getRequest()->getParam('attribute_id')]);
    }

    public function getDeleteUrl()
    {
        return $url = $this->getUrl('*/*/delete',['attribute_id' => $this->getRequest()->getParam('attribute_id')]);
    }

    public function getAssignedGroup()
    {
        $vendorId = Mage::getModel('vendor/session')->getId();
        $attributeId = $this->getRequest()->getParam('attribute_id');
        $collection = Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId.'_%'));
        $collection->getSelect()
        ->join(
            ['pa' => 'eav_entity_attribute'],
            'pa.attribute_id = main_table.attribute_id',
            ['*']
        )->where('pa.attribute_id = ?', $attributeId);
        return $attributeGroupId = $collection->getData()[0]['attribute_group_id'];
    }
}
