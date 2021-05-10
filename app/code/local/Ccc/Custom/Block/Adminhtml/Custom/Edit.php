<?php

class Ccc_Custom_Block_Adminhtml_Custom_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';        
        $this->_blockGroup = 'ccc_custom';
        $this->_controller = "adminhtml_custom";
        $this->_updateButton('save', 'label',Mage::helper('custom')->__('Save Custom'));
        $this->_updateButton('delete', 'delete',Mage::helper('custom')->__('Delete Custom'));
    }

    public function getHeaderText()
    {
        if(Mage::registry('custom_data') && Mage::registry('custom_data')->getId()){
            return Mage::helper('custom')->__("Edit Custom");
        } else {
            return Mage::helper('custom')->__('Add Custom');
        }
    }
}