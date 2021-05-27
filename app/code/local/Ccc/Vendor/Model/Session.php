<?php
class Ccc_Vendor_Model_Session extends Mage_Core_Model_Session_Abstract
{

    protected $_vendor;

    public function __construct()
    {
        $this->init('adminhtml');
    }

    public function isLoggedIn()
    {
        return (bool)$this->getId() && (bool)$this->checkVendorId($this->getId());
    }

    public function checkVendorId($vendorId)
    {
        if ($this->_isVendorIdChecked === null) {
            $this->_isVendorIdChecked = Mage::getResourceSingleton('vendor/vendor')->checkVendorId($vendorId);
        }
        return $this->_isVendorIdChecked;
    }

    public function setVendor(Ccc_Vendor_Model_Vendor $vendor)
    {
        // check if vendor is not confirmed
        if ($vendor->isConfirmationRequired()) {
            if ($vendor->getConfirmation()) {
                return $this->_logout();
            }
        }
        $this->_vendor = $vendor;
        $this->setId($vendor->getId());
        // save vendor as confirmed, if it is not
        if ((!$vendor->isConfirmationRequired()) && $vendor->getConfirmation()) {
            $vendor->setConfirmation(null)->save();
            $vendor->setIsJustConfirmed(true);
        }
        return $this;
    }

    public function getVendor()
    {
        if ($this->_vendor instanceof Ccc_Vendor_Model_vendor) {
            return $this->_vendor;
        }

        $vendor = Mage::getModel('vendor/vendor');
        if ($this->getId()) {
            $vendor->load($this->getId());
        }

        $this->setVendor($vendor);
        return $this->_vendor;
    }

    public function login($username, $password)
    {
        /** @var $vendor Mage_Vendor_Model_Vendor */
        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());

        if ($vendor->authenticate($username, $password)) {
            $this->setVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    public function setVendorAsLoggedIn($vendor)
    {
        $this->setVendor($vendor);
        $this->renewSession();
        Mage::getSingleton('core/session')->renewFormKey();
        Mage::dispatchEvent('vendor_login', array('vendor'=>$vendor));
        return $this;

    }

    public function authenticate(Mage_Core_Controller_Varien_Action $action, $loginUrl = null)
    {
        if ($this->isLoggedIn()) {
            return true;
        }

        $this->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
        if (isset($loginUrl)) {
            $action->getResponse()->setRedirect($loginUrl);
        } else {
            $action->setRedirectWithCookieCheck(Mage_Vendor_Helper_Data::ROUTE_ACCOUNT_LOGIN,
                Mage::helper('vendor')->getLoginUrlParams()
            );
        }

        return false;
    }

    public function logout()
    {
        if ($this->isLoggedIn()) {
            Mage::dispatchEvent('vendor_logout', array('vendor' => $this->getVendor()) );
            $this->_logout();
        }
        return $this;
    }

    protected function _logout()
    {
        $this->setId(null);
        $this->getCookie()->delete($this->getSessionName());
        Mage::getSingleton('core/session')->renewFormKey();
        return $this;
    }
}