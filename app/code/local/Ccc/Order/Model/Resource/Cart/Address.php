<?php

class Ccc_Order_Model_Resource_Cart_Address extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
	{
		$this->_init('order/cart_address', 'address_id');
    }
}
