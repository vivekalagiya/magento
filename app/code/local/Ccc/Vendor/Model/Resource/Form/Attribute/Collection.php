<?php

class Ccc_Vendor_Model_Resource_Form_Attribute_Collection extends Mage_Eav_Model_Resource_Form_Attribute_Collection
{
    protected $_moduleName = 'vendor';

    /**
     * Current EAV entity type code
     *
     * @var string
     */
    protected $_entityTypeCode = 'vendor';

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('eav/attribute', 'vendor/form_attribute');
    }

    protected function _getEavWebsiteTable()
    {
        return $this->getTable('vendor/eav_attribute_website');
    }

}
