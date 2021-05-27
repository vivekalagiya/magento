<?php

class Ccc_Vendor_Block_Account_Login extends Mage_Core_Block_Template 
{
    public function getCreateAccountUrl()
    {
        $url = $this->getData('create_account_url');
        if (is_null($url)) {
            $url = $this->helper('vendor')->getRegisterUrl();
        }
        return $url;
    }

    public function getPostActionUrl()
    {
        return $this->helper('vendor')->getLoginPostUrl();
    }
}
