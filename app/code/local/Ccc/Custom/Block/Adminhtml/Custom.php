<?php

class Ccc_Custom_Block_Adminhtml_Custom extends Mage_Adminhtml_Block_Widget_Grid_Container 
{
    public function __construct()
    {
        $this->_controller = "adminhtml_custom";    
        $this->_headerText = Mage::helper('custom')->__("Manage Custom");
        $this->_blockGroup = "ccc_custom";
        $this->_addButtonLabel = Mage::helper('custom')->__("Add Custom");   
        parent::__construct();
    }
}
