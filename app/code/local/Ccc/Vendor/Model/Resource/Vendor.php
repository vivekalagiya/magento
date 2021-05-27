<?php
class Ccc_Vendor_Model_Resource_Vendor extends Mage_Eav_Model_Entity_Abstract
{

	const ENTITY = 'vendor';
	
	public function __construct()
	{

		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');

	   parent::__construct();
    }

	public function loadByEmail(Ccc_Vendor_Model_Vendor $vendor, $email, $testOnly = false)
    {
        $adapter = $this->_getReadAdapter();
        $bind    = array('vendor_email' => $email);
        $select  = $adapter->select()
            ->from($this->getEntityTable().'_varchar', array($this->getEntityIdField()))
            ->where('value = :vendor_email');

        $vendorId = $adapter->fetchOne($select, $bind);
        if ($vendorId) {
            $this->load($vendor, $vendorId);
        } else {
            $vendor->setData(array());
        }

        return $this;
    }

	public function checkVendorId($vendorId)
    {
        $adapter = $this->_getReadAdapter();
        $bind    = array('entity_id' => (int)$vendorId);
        $select  = $adapter->select()
            ->from($this->getTable('vendor'), 'entity_id')
            ->where('entity_id = :entity_id')
            ->limit(1);

        $result = $adapter->fetchOne($select, $bind);
        if ($result) {
            return true;
        }
        return false;
    }

}