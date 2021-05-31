<?php


class Ccc_Order_Block_Adminhtml_Order_Cart_Form_CartTotal extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        parent::__construct();
        $this->_blockGroup = 'order';
        $this->_controller = 'Adminhtml_order_cart_form_cartTotal';
        $this->_headerText = 'Cart Total';
    }
}
