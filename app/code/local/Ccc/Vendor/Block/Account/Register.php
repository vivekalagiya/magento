<?php

class Ccc_Vendor_Block_Account_Register extends Mage_Core_Block_Template 
{
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)) {
            $formData = Mage::getSingleton('vendor/session')->getVendorFormData(true);
            $data = new Varien_Object();
            if ($formData) {
                $data->addData($formData);
                // $data->seVendorData(1);
            }
            if (isset($data['region_id'])) {
                $data['region_id'] = (int)$data['region_id'];
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }

    public function isNewsletterEnabled()
    {
        return Mage::helper('core')->isModuleOutputEnabled('Mage_Newsletter');
    }

    public function getBackUrl()
    {
        $url = $this->getData('back_url');
        if (is_null($url)) {
            $url = $this->helper('vendor')->getLoginUrl();
        }
        return $url;
    }

    public function getPostActionUrl()
    {
        return $this->helper('vendor')->getRegisterPostUrl();
    }

}
