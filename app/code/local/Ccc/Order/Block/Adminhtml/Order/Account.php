<?php


class Ccc_Order_Block_Adminhtml_Order_Account extends Mage_Adminhtml_Block_Template
{
    protected $order;
    
    public function getHeaderText()
    {
        return Mage::helper('order')->__('Account Information');
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
