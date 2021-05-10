<?php

class Ccc_Browse_Block_Adminhtml_Browse_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'browse';
        $this->_controller = 'adminhtml_browse';
        $this->_headerText = $this->__('Edit Browse');
        parent::__construct();
    }
}
