<?php

class Ccc_Vendor_Adminhtml_VendorproductController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('vendor');
        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendorproduct'));
        $this->renderLayout();
    }
    
    protected function _initVendorProduct()
    {
        $this->_title($this->__('Vendor Product'))
        ->_title($this->__('Manage Vendor Product'));
        
        $vendorProductId = (int) $this->getRequest()->getParam('id');
        // echo $vendorProductId;die;
        $vendorProduct   = Mage::getModel('vendor/product')
        ->setStoreId($this->getRequest()->getParam('store', 0))
        ->load($vendorProductId);


        Mage::register('current_vendorproduct', $vendorProduct);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $vendorProduct;
    }

    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function editAction()
    {
        $vendorProductId = (int) $this->getRequest()->getParam('id');
        $vendorProduct   = $this->_initVendorProduct();
        // echo '<pre>';
        // print_r($vendorProduct);die;
        if ($vendorProductId && !$vendorProduct->getId()) {
            $this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        
        $this->_title($vendorProduct->getName());
        
        $this->loadLayout();
        
        $this->_setActiveMenu('vendor/product');
        // $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendorproduct_edit'));
        
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        
        $this->renderLayout();
        
    }

    public function saveAction()
    {
        try {
            $vendorProductData = $this->getRequest()->getPost('product');
            $vendorProduct = Mage::getSingleton('vendor/product');
            // echo '<pre>';
            // print_r($vendorProduct);die;
            if($productId = $this->getRequest()->getParam('id')){
                if(!$vendorProduct->load($productId)){
                    throw new Exception("No Product Found!");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }

            $vendorProduct->addData($vendorProductData);
            $vendorProduct->save();
            Mage::getSingleton('core/session')->addSuccess("Vendor Product Added.");
            $this->_redirect('*/*/');
            
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {
            $vendorProduct = Mage::getModel('vendor/product');

            if (!($vendorProductId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$vendorProduct->load($vendorProductId)) {
                throw new Exception('vendor product does not exist');
            }

            if (!$vendorProduct->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The vendor product has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    
    }

    public function approveAction()
    {
        $productId = (int)$this->getRequest()->getParam('id');
        $requestModel = Mage::getModel('vendor/product_request')->load($productId, 'product_id');
        $catalogProduct = Mage::getModel('catalog/product');
        $vendorProduct = Mage::getModel('vendor/product')->load($productId);   

        $requestType = $requestModel->getRequestType();
        $requestId = $requestModel->getRequestId();
        $data = $vendorProduct->getData();

        $defaultAttributeSetId = Mage::getModel('vendor/product')->getDefaultAttributeSetId();

        
        try {
            if($requestType == 'insert') {
                $data['entity_id'] = null;
                $catalogProduct->addData($data)
                    ->setAttributeSetId($defaultAttributeSetId)
                    ->setEntityTypeId($this->_entityTypeId)
                    ->setTypeId('simple');
                $catalogProduct->save();
                
                $requestModel->setApproveStatus('approved')
                ->setApprovedAt(date('Y-m-d H:i:s'))
                ->setCatalogProductId($catalogProduct->getId());
                $requestModel->save();

                Mage::getSingleton('core/session')->addSuccess('Product Inserted.');
            }
            if($requestType == 'update') {
                $catalogProductId = $requestModel->getCatalogProductId();
                $catalogProduct->load($catalogProductId);
                $catalogProduct->addData($data)
                    ->setEntityId($catalogProductId)
                    ->setAttributeSetId($defaultAttributeSetId)
                    ->setEntityTypeId($this->_entityTypeId)
                    ->setTypeId('simple');
                $catalogProduct->save();
                
                $requestModel->setApproveStatus('approved')
                ->setApprovedAt(date('Y-m-d H:i:s'));
                $requestModel->save();
                    
                Mage::getSingleton('core/session')->addSuccess('Product Updated.');
            }
            if($requestType == 'delete') {
                
                $vendorProduct->delete();
                
                $requestModel->setApproveStatus('approved')
                ->setApprovedAt(date('Y-m-d H:i:s'));
                $requestModel->save();
                Mage::getSingleton('core/session')->addSuccess('Product Deleted.');
                
            }
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            $e->getMessage();die;
        }

    }

    public function rejectAction()
    {
        $productId = (int)$this->getRequest()->getParam('id');
        $requestModel = Mage::getModel('vendor/product_request')->load($productId, 'product_id');
        $vendorProduct = Mage::getModel('vendor/product')->load($productId);   

        $requestType = $requestModel->getRequestType();
        $requestId = $requestModel->getRequestId();
        $data = $vendorProduct->getData();

        $requestModel->setApproveStatus('rejected')
        ->setApprovedAt(date('Y-m-d H:i:s'));
        $requestModel->save();

        // if($requestType == 'insert') {

            
        //     $requestModel->setApproveStatus('rejected')
        //     ->setApprovedAt(date('Y-m-d H:i:s'));
        //     $requestModel->save();

        // }
        // if($requestType == 'update') {

                
        //     $requestModel->setApproveStatus('rejected')
        //     ->setApprovedAt(date('Y-m-d H:i:s'));
        //     $requestModel->save();
                
        // }
        // if($requestType == 'delete') {
            
        //     $requestModel->setApproveStatus('rejected')
        //     ->setApprovedAt(date('Y-m-d H:i:s'));
        //     $requestModel->save();
            
        // }

        Mage::getSingleton('core/session')->addSuccess('Request Rejected.');
        $this->_redirect('*/*/');        
        

    }
}


?>