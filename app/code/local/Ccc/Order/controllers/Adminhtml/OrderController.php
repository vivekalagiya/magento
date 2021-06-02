<?php

class Ccc_Order_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('order/session');
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

    public function viewAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->_title('Order Grid')->_title('Orders');
        $orderId = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('order/order')->load($orderId);
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        $order->setCustomer($customer);
        $this->getLayout()->getBlock('content')->setOrder($order);
        $this->renderLayout();
    }
}
