<?php

class Ccc_Order_Model_Resource_Cart_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract 
{
    public function _construct()
    {
        $this->_init('order/cart');
    }
}
