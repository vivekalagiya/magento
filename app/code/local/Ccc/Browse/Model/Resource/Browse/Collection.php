<?php

class Ccc_Browse_Model_Resource_Browse_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('browse');
		parent::__construct();
		
	}
}