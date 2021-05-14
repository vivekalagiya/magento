<?php

class Ccc_Browse_Block_Adminhtml_Browse extends Mage_Adminhtml_Block_Widget_Grid_Container   
{
    public function __construct()
    {
        $this->_blockGroup = 'browse';
        $this->_controller = 'adminhtml_browse';
        $this->_headerText = $this->__('Browse Grid');
        parent::__construct();
    }
}



?>