<?php


class Ccc_Vendor_Block_Account_Logout extends Mage_Core_Block_Template 
{
    public function getNewUrl()
    {
        return $url = $this->getUrl('*/*/login');
    }
}
