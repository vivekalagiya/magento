<?php

class Ccc_Order_Model_Cart_Item extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('order/cart_item');
    }
}
