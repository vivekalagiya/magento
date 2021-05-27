<?php

class Ccc_Vendor_Block_Marketplace_Group_Form extends Mage_Core_Block_Template
{
    public function getGroupName()
    {
        $groupId = $this->getRequest()->getParam('group_id');
        $collection = Mage::getResourceModel('vendor/product_attribute_group_collection')
            ->addFieldToFilter('attribute_group_id', array("eq" => $groupId));
        return $collection;
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['group_id' => $this->getRequest()->getParam('group_id')]);
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['group_id' => $this->getRequest()->getParam('group_id')]);
    }
    protected function _getSession()
    {
        return Mage::getSingleton('vendor/session');
    }

    public function getAssignedAttribute()
    {
        $vendorId = $this->_getSession()->getVendor()->getId();
        $groupId = $this->getRequest()->getParam('group_id');
        $collection = Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId.'_%'));
            $collection->getSelect()
            ->join(
                ['pa' => 'eav_entity_attribute'],
                'pa.attribute_id = main_table.attribute_id',
                ['*']
            )
            ->where('pa.attribute_group_id = ?', $groupId);
        // echo '<pre>';
        // print_r($collection->getData());
        // die;

        return $collection;
    }

    public function getAllAssignedAttribute()
    {
        $vendorId = $this->_getSession()->getVendor()->getId();
        $groupId = $this->getRequest()->getParam('group_id');
        $collection = Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId.'_%'));
        $collection->getSelect()
        ->join(
            ['pa' => 'eav_entity_attribute'],
            'pa.attribute_id = main_table.attribute_id',
            ['*']
        );
        return $collection;
    }
        
        public function getUnassignedAttribute()
        {
            $vendorId = $this->_getSession()->getVendor()->getId();
            $groupId = $this->getRequest()->getParam('group_id');
            // $assignedAttribute = $this->getAllAssignedAttribute();
            $collection = Mage::getResourceModel('vendor/product_attribute_collection')
            ->addFieldToFilter('attribute_code', array('like' => $vendorId.'_%'));
            // echo '<pre>';
            // print_r($collection->getData());die;
            if($this->getAllAssignedAttribute()->getData()){
                $collection->addFieldToFilter('main_table.attribute_id', array('nin' => $this->getAllAssignedAttribute()->getData()));
            }
        
        return $collection;  
    }



}
