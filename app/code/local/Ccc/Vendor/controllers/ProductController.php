<?php


class Ccc_Vendor_ProductController extends Mage_Core_Controller_Front_Action 
{

    public function newAction()
    {
        $this->_forward('edit');
    }

    protected function _initProduct()
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Manage Products'));

        $productId = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('vendor/product')
            ->setStoreId($this->getRequest()->getParam('store', 0));

        if (!$productId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
        } else {
            $product->load($productId);
        }
        Mage::register('current_product', $product);
        return $product;
    }

    protected function _getSession()
    {
        return Mage::getSingleton('vendor/session');
    }

    public function editAction()
    {
        if (!$this->_getSession()->isLoggedIn()) {
            $this->_redirect('vendor/account/login');
            return;
        }
        $productId = (int) $this->getRequest()->getParam('id');

        $product = $this->_initProduct();

        if ($productId && !$product->getId()) {
            $this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $postData = $this->getRequest()->getPost();
            $productId = $this->getRequest()->getParam('product_id');
            $product = Mage::getModel('vendor/product');
            if($productId) {
                if(!$product->load($productId)){
                    throw new Exception("No product foud!");
                    
                }
            } else {
                $sku = $postData['sku'];
                if(!$product->validateSku($sku)){
                    throw new Exception("Sku already exist with same name.");
                }
                
            }

            $vendorId = Mage::getModel('vendor/session')->getId();
            $product->addData($postData);
            // $product->setVendorId($vendorId);
            $product->save();
            $query = "UPDATE `vendor_product` SET `vendor_id` = '{$vendorId}' WHERE `entity_id` = '{$product->getId()}' ";
            $conn = Mage::getSingleton('core/resource')->getConnection('core_write')->query($query);
            
            /**********sent request to admin***********/
            $productId = $product->getId();

            if($productId){
                $request = Mage::getModel('vendor/product_request')->load($productId, 'product_id');
            }

            if($request->getCatalogProductId()){
                $requestType = 'update';
            }else{
                $requestType = 'insert';
            }
            $approveStatus = 'pending';
            
            $request->setVendorId($vendorId)
                ->setProductId($productId)
                ->setRequestType($requestType)
                ->setApproveStatus($approveStatus)
                ->setCreatedAt($createdDate);
                
                $request->save();
                
                /*******************************************/
                Mage::getSingleton('vendor/session')->addSuccess('Product add successfully');
                
        } catch (Exception $e) {
            Mage::getSingleton('vendor/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/grid');
        
            
        }
        
        public function deleteAction()
        {
            $productId = $this->getRequest()->getParam('id');
            $vendorId = Mage::getModel('vendor/session')->getId();
            $requestType = 'delete';
            $approveStatus = 'pending';
            $createdDate = date('Y-m-d H:i:s');
            
            $request = Mage::getModel('vendor/product_request')->load($productId, 'product_id');
            $request->setVendorId($vendorId)
            ->setProductId($productId)
            ->setRequestType($requestType)
            ->setApproveStatus($approveStatus)
            ->setCreatedAt($createdDate);
            
        // echo '<pre>';
        // print_r($request);
        // die;
        $request->save();
        $this->_redirect('*/*/grid');

    }
}
