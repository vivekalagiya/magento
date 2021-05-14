<?php

class Ccc_Browse_Adminhtml_BrowseController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('browse');
        $this->_title('Browse Grid');
        $this->_addcontent($this->getLayout()->createBlock('browse/adminhtml_browse'));
        $this->renderLayout();  
    }

    public function _initBrowse()
    {
        $this->_title($this->__('Browse'))
        ->_title($this->__('Manage Browse'));
        $browseId = (int) $this->getRequest()->getParam('id');
        $browse = Mage::getModel('browse/browse')
            ->setStoreId($this->getRequest()->getParam('store',0))
            ->load($browseId);
        Mage::register('current_browse', $browse);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));   
        return $browse;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $browseId = (int) $this->getRequest()->getParam('id');
        $browse = $this->_initBrowse();

        if($browseId && !$browse->getId()) {
            $this->_getSession()->addError(Mage::helper('browse')->__('Browse no longer exist!'));
            $this->_redirect('*/*/');
            return;
        }

        $this->loadLayout();
        $this->_setActiveMenu('browse');
        $this->_title($browse->getName());
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }


    public function saveAction()
    {
        try {
            $browseData = $this->getRequest()->getParam('browse');
            $browseId = $this->getRequest()->getParam('id');
            $browse = Mage::getSingleton('browse/browse');

            if($browseId) {
                if(!$browse->load($browseId)) {
                    throw new Exception("Unable to add record.");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

            }

            $browse->addData($browseData);
            $browse->save();

            Mage::getSingleton('core/session')->addSuccess('browse add successfully.');
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {
            $browseModel = Mage::getModel('browse/browse');
            if (!($browseId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$browseModel->load($browseId)) {
                throw new Exception('browse does not exist');
            }

            if (!$browseModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess('The Browse has been deleted.');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            
        }
        $this->_redirect('*/*/');
    }
}



?>