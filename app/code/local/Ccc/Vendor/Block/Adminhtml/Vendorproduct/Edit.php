<?php

class Ccc_Vendor_Block_Adminhtml_Vendorproduct_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_vendorproduct';
        $this->_headerText = $this->__('Vendor Product Form');
        parent::__construct();
    }
}

