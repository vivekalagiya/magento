<?php

class Ccc_Vendor_Model_Resource_Product extends Mage_Eav_Model_Entity_Abstract
{

	const ENTITY = 'vendor_product';
	
	public function __construct()
	{

		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');

	   parent::__construct();
    }

}