<?php


class Ccc_Order_Block_Adminhtml_Order_Cart_Form_ShippingAddress extends Mage_Adminhtml_Block_Widget_Form
{
    public function getHeaderText()
    {
        return Mage::helper('order')->__('Shipping Address');
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

    public function getShippingAddress()
    {
        
        $shippingAddress = $this->getCart()->getShippingAddress();
        
        if(!$shippingAddress->getId()) {
            $customerId = $this->getCart()->getCustomerId();
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $shippingAddress = $customer->getDefaultShippingAddress();
        }

        if(!$shippingAddress){
            $shippingAddress = Mage::getModel('order/cart_address');
        }
        return $shippingAddress;
    }

}
