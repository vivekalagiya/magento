<?php

class Ccc_Vendor_Block_Adminhtml_VendorProduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_vendorProduct';
        $this->_headerText = $this->__('Vendor Product Grid');
        parent::__construct();
    }
}
