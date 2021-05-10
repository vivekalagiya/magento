<?php
class Ccc_Custom_Model_Resource_Data_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('ccc_custom/data');
    }
}