<?php

class Ccc_Browse_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_Browse';

    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('browse/attribute');
    }
}
