<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Form_BillingAddress_Form extends Mage_Adminhtml_Block_Template
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

    public function getBillingAddress()
    {
        
        $billingAddress = $this->getCart()->getBillingAddress();
        
        if(!$billingAddress->getId()) {
            $customerId = $this->getCart()->getCustomerId();
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $billingAddress = $customer->getDefaultBillingAddress();
        }

        if(!$billingAddress){
            $billingAddress = Mage::getModel('order/cart_address');
        }
        return $billingAddress;
    }


    

}
