<?php

class Ccc_Vendor_Block_Marketplace_Product_Edit_Form extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('vendor/marketplace/product/edit/form.phtml');
    }
    public function getResetUrl()
    {
        if ($this->getRequest()->getParam('new')) {
            return $this->getUrl('vendor/product/new');
        }
        if ($productId = $this->getRequest()->getParam('product_id')) {
            return $this->getUrl('vendor/product/edit/product_id/' . $productId);
        }
    }
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save',['product_id'=>$this->getRequest()->getParam('id')]);
    }
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete',['product_id'=>$this->getRequest()->getParam('id')]);
    }
}
