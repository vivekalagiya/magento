<?php


class Ccc_Order_Block_Adminhtml_Order_ShipmentMethod extends Mage_Adminhtml_Block_Widget_Form
{
    public function getHeaderText()
    {
        return Mage::helper('order')->__('Shipment Method');
    }

}
