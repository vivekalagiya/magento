<?php


class Ccc_Order_Block_Adminhtml_Order_Account extends Mage_Adminhtml_Block_Template
{
    protected $cart;
    
    public function getHeaderText()
    {
        return Mage::helper('order')->__('Account Information');
    }

    
    public function setCart(Ccc_Order_Model_Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }

    public function getCart()
    {
        if(!$this->cart){
            $this->setCart(Mage::getModel('order/cart'));
        }
        return $this->cart;
    }
   
}
