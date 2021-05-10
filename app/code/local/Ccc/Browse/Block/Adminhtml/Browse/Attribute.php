<?php

class Ccc_Browse_Block_Adminhtml_Browse_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_browse_attribute';
        $this->_blockGroup = 'browse';
        $this->_headerText = Mage::helper('browse')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('browse')->__('Add Attribute');
        parent::__construct();
    }
}
