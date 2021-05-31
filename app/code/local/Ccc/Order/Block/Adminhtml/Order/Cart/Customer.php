<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        parent::__construct();
        $this->_blockGroup = 'order';
        $this->_controller = 'adminhtml_order_cart_customer';
        $this->_headerText = "select customer";
    }
}
