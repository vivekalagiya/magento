<?php

class Ccc_Order_Block_Adminhtml_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'order';
        $this->_controller = 'adminhtml_order';
        $this->_headerText = $this->__('Order Grid');
        $this->_addButtonLabel = "create new order";
        parent::__construct();
    }
}
