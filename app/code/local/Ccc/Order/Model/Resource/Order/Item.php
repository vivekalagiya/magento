<?php

class Ccc_Order_Model_Resource_Order_Item extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
	{
		$this->_init('order/order_item', 'item_id');
    }
}
