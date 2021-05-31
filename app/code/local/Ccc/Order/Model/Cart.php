<?php

class Ccc_Order_Model_Cart extends Mage_Core_Model_Abstract 
{

    protected $customer = Null;
    protected $item = Null;
    protected $items = Null;
    protected $billingAddress = Null;
    protected $shippingAddress = Null;
    protected $shipmentMethod = Null;
    protected $paymentMethod = Null;

    public function _construct()
    {
        parent::_construct();
        $this->_init('order/cart');
    }

    public function setCustomer(Mage_Customer_Model_Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function getCustomer()
    {
        if(!$this->customer_id) {
            return false;   
        }
        if(!$this->customer){
            $customer = Mage::getModel('customer/customer')->load($this->customer_id);
            $this->setCustomer($customer);
        }
        return $this->customer;
    }

    public function setPaymentMethods($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function getPaymentMethods()
    {
        if(!$this->paymentMethod){
            $methods = Mage::getModel('payment/config');
            $activemethod = $methods->getActiveMethods();
            unset($activemethod['paypal_billing_agreement']);
            unset($activemethod['checkmo']);
            unset($activemethod['free']);
            $this->setPaymentMethods($activemethod);

        }
    	return $this->paymentMethod;
    }

    public function setShipmentMethods($shipmentMethod)
    {
        $this->shipmentMethod = $shipmentMethod;
        return $this;
    }
        

    public function getShipmentMethods()
    {
        if(!$this->shipmentMethod){
            $this->setShipmentMethods(Mage::getModel('shipping/config')->getActiveCarriers()); 
        }

        return $this->shipmentMethod;
    }

    public function setItem(Ccc_Order_Model_Cart_Item $item)
    {
        $this->item = $item;
        return $this;
    }

    public function getItem()
    {
        if(!$this->getId()) {
            return false;   
        }
        if(!$this->item){
            $item = Mage::getModel('order/cart_item');
            $this->setItem($item);
        }
        return $this->item;
    }

    public function setItems(Ccc_Order_Model_Resource_Cart_Item_Collection $items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItems()
    {
        if(!$this->getId()) {
            return false;   
        }
        if(!$this->items){
            $items = Mage::getModel('order/cart_item')->getCollection()
                ->addFieldToFilter('cart_id',['eq' => $this->getId()]);
            $this->setItems($items);
        }
        return $this->items;
    }

    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function getBillingAddress()
    {
        
        if(!$this->cart_id) {
            return false;   
        }
        $address = Mage::getModel('order/cart_address')->getResourceCollection()
        ->addFieldToFilter('address_type', ['eq' => 'billing'])
        ->addFieldToFilter('cart_id', ['eq' => $this->cart_id]);
        
        $billingAddress = $address->getFirstItem();
        
        return $billingAddress;
        
    }

    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function getShippingAddress()
    {
        if(!$this->cart_id) {
            return false;   
        }
        $address = Mage::getModel('order/cart_address')->getResourceCollection()
                    ->addFieldToFilter('address_type', ['eq' => 'shipping'])
                    ->addFieldToFilter('cart_id', ['eq' => $this->cart_id]);

        return $shippingAddress = $address->getFirstItem();

    }

    

    public function getCartTotal()
    {
        $items = $this->getItems();
        $price = 0;
        foreach ($items as $item) {
            $productId = $item->getProductId();
            $product = Mage::getModel('catalog/product')->load($productId);
            $price += $product->getPrice() * $item->getQuantity();
            
        }
        return $price;
    }

    public function getGrandTotal()
    {
        $cartTotal = $this->getCartTotal();
        $shippingAmount = $this->getShippingAmount();
        return $grandTotal = $cartTotal + $shippingAmount;
    }

    public function updateCart()
    {
        $cart = $this;
        $cart->setTotal($this->getGrandTotal());
        $cart->save();
    }


    
}

