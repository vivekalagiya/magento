<?php


class Ccc_Vendor_OrderController extends Mage_Core_Controller_Front_Action 
{

    public function gridAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');
        $this->renderLayout();
    }
}
