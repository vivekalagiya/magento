<?php

class Ccc_Order_Model_Order_Item extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('order/order_item');
    }
}
