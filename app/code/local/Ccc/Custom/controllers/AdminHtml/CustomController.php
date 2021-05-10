<?php

class ccc_custom_Adminhtml_CustomController extends Mage_Adminhtml_Controller_Action
{

    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('Custom/Custom')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Manage Custom'),
                Mage::helper('adminhtml')->__('Manage Custom')
            );
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('ccc_custom_admin/custom'));
        $this->_title($this->__("Custom Grid"));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }
        
    public function editAction()
    {
        $customId = $this->getRequest()->getParam('id');
        $customModel = Mage::getModel('ccc_custom/data')->load($customId);
        if ($customModel->getData() || $customId == 0) {
            Mage::register('custom_data', $customModel);
            $this->loadLayout();
            $this->_setActiveMenu('Custom/Custom');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('ccc_custom/adminhtml_custom_edit'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custom')->__(
                'Custom does not exists!'
            ));
            $this->_redirect('*/*/');
        } 
    }

    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                $customId = $this->getRequest()->getParam('id');
                $customModel = Mage::getModel('ccc_custom/data')->load($customId);
                // echo '<pre>';
                // print_r($postData);die;
                if ($customModel->getId()) {
                    $customModel->setFirstName($postData['first_name'])
                        ->setLastName($postData['last_name'])
                        ->save();
                } else {
                    $customModel->setId($this->getRequest()->getParam('id'))
                        ->setFirstName($postData['first_name'])
                        ->setLastName($postData['last_name'])
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('User saved successfully!'));
                Mage::getSingleton('adminhtml/session')->setUserData(false);
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setUserData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
        }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $userModel = Mage::getModel('ccc_custom/data');
                $userModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Custom deleted successfully!'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

}



?>