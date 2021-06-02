<?php

class Ccc_Order_Block_Adminhtml_Order_BillingAddress_Form extends Mage_Adminhtml_Block_Template
{

    protected $order;

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

    public function getCountries()
    {
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }    

}
