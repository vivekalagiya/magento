<?php


class Ccc_Vendor_GroupController extends Mage_Core_Controller_Front_Action 
{

    protected $_entityTypeId;

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');
        $this->renderLayout();
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('vendor/session');
        
        $this->renderLayout();
    }

    public function preDispatch()
    {
        // $this->_setForcedFormKeyActions('delete');
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType(Ccc_Vendor_Model_Resource_Product::ENTITY)->getTypeId();
    }

    public function _getAssignedAttribute()
    {
        $vendorId = Mage::getModel('vendor/session')->getId();
        $groupId = $this->getRequest()->getParam('group_id');
        $collection = Mage::getModel('vendor/resource_product_attribute_collection')
            ->addFieldToFilter(
                'attribute_code',
                array('like' => '%' . $vendorId)
            );
        $collection->getSelect()
            ->join(
                array('product_attribute' => 'eav_entity_attribute'),
                'product_attribute.attribute_id = main_table.attribute_id',
                array('*')
            )
            ->where('product_attribute.attribute_group_id = ?', $groupId);
        return $collection;
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        // echo '<pre>';
        // print_r($data);
        // die;
        $groupId = $this->getRequest()->getParam('group_id');
        $vendorId = Mage::getSingleton('vendor/session')->getId();

        $model = Mage::getModel('eav/entity_attribute_group')->load($groupId);
        $defaultAttributeSetId = Mage::getModel('vendor/product')->getDefaultAttributeSetId();
        $model->setAttributeGroupName($vendorId.'_'.$data['group'])
         ->setAttributeSetId($defaultAttributeSetId);
        
        if( !$groupId && $model->itemExists()  ) {

            Mage::getSingleton('vendor/session')->addError(Mage::helper('vendor')->__('A group with the same name already exists.'));
            $this->_redirect('*/*/edit',['group_id' => $this->getRequest()->getParam('group_id')]);
        } else {
            try {
                if($groupId) {
                    
                    // $assignedAttributes = $this->_getAssignedAttribute();
                    
                    // foreach ($assignedAttributes as $assignedAttribute) {
                    //     $oldAssignedAttribute[] = $assignedAttribute->getData()['attribute_id'];
                    // }
                    
                    // foreach ($data['assigned'] as $key => $value) {
                    //     $newAssignedAttribute[] = $key;
                    // }
                    
                    
                    // if (is_null($newAssignedAttribute)) {
                        //     $result = $oldAssignedAttribute;
                        // } else {
                            //     $result = array_diff($oldAssignedAttribute, $newAssignedAttribute);
                            // }
                            
                    $conn = Mage::getSingleton('core/resource')->getConnection('core_write');
                    foreach ($data['assigned'] as $attributeId => $value) {
                        $sql = "DELETE FROM `eav_entity_attribute` WHERE `attribute_id` = $attributeId ";
                        $conn->query($sql);
                    }   
                    
                    foreach($data['unassigned'] as $attributeId => $value) {
                        
                        $defaultAttributeSetId = Mage::getModel('vendor/product')->getDefaultAttributeSetId();
                        $attributeModel = Mage::getModel('eav/entity_attribute')
                        ->setEntityTypeId($this->_entityTypeId)
                        ->setAttributeSetId($defaultAttributeSetId)
                        ->setAttributeGroupId($groupId)
                        ->setAttributeId($attributeId);
                        
                        // echo '<pre>';
                        // print_r($attributeModel);
                        // die;
                        $attributeModel->save();
                    }
                    
                    } 
                    
                    $model->save();
                    $groupModel = Mage::getModel('vendor/product_attribute_group')->load($groupId, 'attribute_group_id');
                    $groupModel->setAttributeGroupName($data['group'])
                    ->setAttributeGroupId($model->getAttributeGroupId())
                    ->setEntityId($vendorId);
                    $groupModel->save();
                    foreach($data['unassigned'] as $attributeId => $value) {
                        
                        $defaultAttributeSetId = Mage::getModel('vendor/product')->getDefaultAttributeSetId();
                        $attributeModel = Mage::getModel('eav/entity_attribute')
                        ->setEntityTypeId($this->_entityTypeId)
                        ->setAttributeSetId($defaultAttributeSetId)
                        ->setAttributeGroupId($model->getId())
                        ->setAttributeId($attributeId);
                        
                        // echo '<pre>';
                        // print_r($attributeModel);
                        // die;
                        $attributeModel->save();
                    }
                    Mage::getSingleton('vendor/session')->addSuccess(Mage::helper('vendor')->__('Group has been updated.'));
                    if($groupId) {
                        
                        $this->_redirect('*/*/edit',['group_id' => $groupId]);
                    }else{
                        
                        $this->_redirect('*/*/grid');
                    }
                    
            } catch (Exception $e) {
                echo $e->getMessage();die;
                Mage::getSingleton('vendor/session')->addError(Mage::helper('vendor')->__('An error occurred while saving this group.'));
                $this->_redirect('*/*/edit',['group_id' => $groupId]);
            }
        }
    }
    
    public function deleteAction()
    {
        try {
            $groupId = $this->getRequest()->getParam('group_id');
            $model = Mage::getModel('eav/entity_attribute_group')->load($groupId)->delete();
            $groupModel = Mage::getModel('vendor/product_attribute_group')->load($groupId, 'attribute_group_id')->delete();
            Mage::getSingleton('vendor/session')->addSuccess(Mage::helper('vendor')->__('Group has been deleted successfully.'));
        } catch (Exception $e) {
            Mage::getSingleton('vendor/session')->addError(Mage::helper('vendor')->__('An error occurred while deleting this group.'));
        }
        $this->_redirect('*/*/grid');
        
    }
}
