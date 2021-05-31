<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Form_ShippingAddress_Form extends Mage_Adminhtml_Block_Widget_Grid 
{

    protected $cart;

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

    public function getCountries()
    {
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }
    
}
