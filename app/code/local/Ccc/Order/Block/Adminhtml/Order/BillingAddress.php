<?php


class Ccc_Order_Block_Adminhtml_Order_BillingAddress extends Mage_Adminhtml_Block_Widget_Form
{

    protected $order;

    public function getHeaderText()
    {
        return Mage::helper('order')->__('Billing Address');
    }

    public function setOrder(Ccc_Order_Model_Order $order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        if(!$this->order){
            $this->setOrder(Mage::getModel('order/order'));
        }
        return $this->order;
    }
  
}
