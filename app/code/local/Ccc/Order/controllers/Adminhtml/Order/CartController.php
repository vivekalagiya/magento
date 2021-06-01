<?php

class Ccc_Order_Adminhtml_Order_CartController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        try {
            $cart = $this->_getCart();
            $this->loadLayout();
            $this->_setActiveMenu('order');
            $this->_title('New Order')->_title('Orders');
            $this->getLayout()->getBlock('content')->setCart($cart);
            $this->_initLayoutMessages('order/session');
            $cart->updateCart();
            $this->renderLayout();
        } catch (Exception $e) {
            Mage::getModel('order/session')->addError($e->getMessage());
            $this->_redirect('*/order/new');
        }
    }

    public function gridAction()
    {
        $this->getResponse()
            ->setBody($this->getLayout()->createBlock('order/adminhtml_order_cart_form_product_grid')->toHtml());
    }

    protected function _getCart()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id');
        $session = Mage::getModel('order/session');
        if($customerId){
            $session->setCustomerId($customerId);
        }
        $customerId = $session->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customerId);
        if($customerId){
            if(!$customer->getId()){
                throw new Exception('Customer not exist!');
            }
        }
        $cart = Mage::getModel('order/cart')->load($customerId, 'customer_id');
        if(!$cart->getId()){
            $cart->setCustomerId($customerId);
            $cart->setCustomerName($customer->getName());
            $cart->setCreatedAt(date('Y-m-d H:i:s'));
            $cart->save();
        }

        $cart->setCustomer($customer);
        return $cart;

    }

    // public function newAction()
    // {
    //     $this->loadLayout();
    //     $this->_setActiveMenu('order');
    //     $this->_title('Order Grid');
    //     $this->_addContent($this->getLayout()->createBlock('order/adminhtml_order_cart'));
    //     $this->renderLayout();
    // }

    public function addToCartAction()
    {
        $cart = $this->_getCart();
        $products = $this->getRequest()->getPost('product');
        foreach ($products as $key => $productId) {
            $product = Mage::getModel('catalog/product');
            $product->load($productId);
            $cartItem = $cart->getItem()->getCollection()
                ->addFieldToFilter('product_id',$productId)
                ->addFieldToFilter('cart_id',$cart->getId())
                ->getFirstItem();
                
            if($cartItem->getId()){
                $cartItem->setQuantity($cartItem->getQuantity() + 1)
                    ->setCreatedAt(date('Y-m-d H:i:s'));
                $cartItem->save();
            } else{
                $cartItem->setCartId($cart->getId())
                    ->setProductId($productId)
                    ->setName($product->getName())
                    ->setSku($product->getSku())
                    ->setQuantity(1)
                    ->setPrice($product->getPrice())
                    ->setCreatedAt(date('Y-m-d H:i:s'));
                $cartItem->save();
            }
        }
        Mage::getSingleton('order/session')->addSuccess('Add Item To Cart successfully.');
        $this->_redirect('*/*/');
    }
    
    public function updateItemQuantityAction()
    {
        $cart = $this->_getCart();
        $postData = $this->getRequest()->getPost();
        foreach ($postData['quantity'] as $item_id => $quantity) {
            $cart->getItem()->load($item_id)
            ->setQuantity($quantity)
            ->save();
        }
        Mage::getSingleton('order/session')->addSuccess('Item quantity updated successfully.');
        $this->_redirect('*/*/');
        
    }
    
    public function saveBillingAddressAction()
    {
        $postData = $this->getRequest()->getPost('billing');
        $cart = $this->_getCart();
        $billingAddress = $cart->getBillingAddress()
            ->addData($postData)
            ->setCartId($cart->getId())
            ->setAddressType('billing');
        $billingAddress->save();
        if($postData['save_in_billing_address']){
            $customer = Mage::getModel('customer/customer')->load($cart->getCustomerId());
            $customerAddress = $customer->getDefaultBillingAddress();
            if(!$customerAddress){
                $customerAddress = Mage::getModel('customer/address')->load($cart->getCustomerId(), 'parent_id');
            }
            $customerAddress->addData($postData)
            ->setParentId($cart->getCustomerId())
            ->setRegion($postData['state'])
            ->setPostcode($postData['zipcode'])
            ->setIsDefaultBilling(1);
            $customerAddress->save();
        }
        $this->_redirect('*/*/');
    }
        
    public function saveShippingAddressAction()
    {
        $postData = $this->getRequest()->getPost('shipping');
        $cart = $this->_getCart();
        if($postData['shipping_as_billing']){
            $billingAddress = $cart->getBillingAddress();
            $shippingAddress = $cart->getShippingAddress()
                ->setCartId($cart->getId())
                ->setFirstname($billingAddress->getFirstname())
                ->setMiddlename($billingAddress->getMiddlename())
                ->setLastname($billingAddress->getLastname())
                ->setStreet($billingAddress->getStreet())
                ->setCity($billingAddress->getCity())
                ->setState($billingAddress->getState())
                ->setCountry($billingAddress->getCountry())
                ->setZipcode($billingAddress->getZipcode())
                ->setAddressType('shipping');
            $shippingAddress->save();
        } else {
            $shippingAddress = $cart->getShippingAddress()
                ->addData($postData)
                ->setCartId($cart->getId())
                ->setAddressType('shipping');
            $shippingAddress->save();
        }
        if($postData['save_in_shipping_address']){
            $customer = Mage::getModel('customer/customer')->load($cart->getCustomerId());
            $customerAddress = $customer->getDefaultShippingAddress();
            if(!$customerAddress){
                $customerAddress = Mage::getModel('customer/address')->load($cart->getCustomerId(), 'parent_id');
            }
            $customerAddress->addData($shippingAddress->getData())
                ->setParentId($cart->getCustomerId())
                ->setRegion($shippingAddress->getState())
                ->setPostcode($shippingAddress->getZipcode())
                ->setIsDefaultShipping(1);
            $customerAddress->save();
        }
        $this->_redirect('*/*/');
    }
    
    public function savePaymentMethodAction()
    {
        $paymentMethod = $this->getRequest()->getPost('paymentMethod');
        $cart = $this->_getCart();
        $cart->setPaymentMethodCode($paymentMethod);
        $cart->save();
        $this->_redirect('*/*/');
    }
    
    public function saveShipmentMethodAction()
    {
        $postData = $this->getRequest()->getPost('shippingMethod');
        $postData = explode('_', $postData);
        $shipmentMethodCode = $postData[0];
        $shippingAmount = $postData[1];
        
        $cart = $this->_getCart();
        $cart->setShippingMethodCode($shipmentMethodCode)
            ->setShippingAmount($shippingAmount);
            $cart->save();
            $this->_redirect('*/*/');
        }
        
        public function deleteItemAction()
        {
            $item_id = array_key_first($this->getRequest()->getPost('delete'));
            $cart = $this->_getCart();
            $cart->getItem()->load($item_id)->delete();
            Mage::getSingleton('order/session')->addSuccess('Item deleted successfully.');
            $this->_redirect('*/*/');
    }

    public function placeOrderAction()
    {
        $cart = $this->_getCart();
        $order = Mage::getModel('order/order');
        $order->setData($cart->getData())
            ->setCreatedAt(date('Y-m-d H:i:s'));
        $order->save();
        
        $items = $cart->getItems();
        foreach ($items as $item) {
            $orderItem = Mage::getModel('order/order_item');
            $orderItem->setData($item->getData())
            ->setOrderId($order->getId())
            ->setCreatedAt(date('Y-m-d H:i:s'));
            $orderItem->save();
            $item->delete();
        }
        
        $billingAddress = $cart->getBillingAddress();
        // echo '<pre>';
        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($billingAddress->getData())
            ->setAddressId(null)
            ->setCreatedAt(date('Y-m_d H:i:s'));
        $orderAddress->save();
        $billingAddress->delete();
        // print_r($orderAddress);
        
        $shippingAddress = $cart->getShippingAddress();
        // echo '<pre>';
        $orderAddress = Mage::getModel('order/order_address');
        $orderAddress->setData($shippingAddress->getData())
        ->setAddressId(null)
        ->setCreatedAt(date('Y-m_d H:i:s'));
        $orderAddress->save();
        $shippingAddress->delete();
        // print_r($orderAddress);
        $cart->delete();
        $this->_redirect('*/order/index');

    }


}
