<?php
class Ccc_Browse_Model_Resource_Browse extends Mage_Eav_Model_Entity_Abstract
{

	const ENTITY = 'browse';
	
	public function __construct()
	{

		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');

	   parent::__construct();
    }

}