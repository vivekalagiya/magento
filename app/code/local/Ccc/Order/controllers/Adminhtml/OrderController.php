<?php

class Ccc_Order_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->_title('Order Grid');
        $this->renderLayout();
    }   

    public function newAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->_title('Order Grid');
        $this->_initLayoutMessages('order/session');
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->_title('Order Grid')->_title('Orders');
        $this->renderLayout();
    }
}
