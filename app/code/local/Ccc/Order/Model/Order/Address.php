<?php

class Ccc_Order_Model_Order_Address extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('order/order_address');
    }

}
