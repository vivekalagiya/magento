<?php


class Ccc_Order_Block_Adminhtml_Order_Cart_Form_ShipmentMethod extends Mage_Adminhtml_Block_Widget_Form
{
    public function getHeaderText()
    {
        return Mage::helper('order')->__('Shipment Method');
    }

}
