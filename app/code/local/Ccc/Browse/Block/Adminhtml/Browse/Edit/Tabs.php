<?php

class Ccc_Browse_Block_Adminhtml_Browse_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('browse')->__('Browse Information'));
    }

    public function getBrowse()
    {
        return Mage::registry('current_browse');
    }

    public function _beforeToHtml()
    {
        $browseAttributes = Mage::getResourceModel('browse/browse_attribute_collection');
        if (!$this->getBrowse()->getId()) {
            foreach ($browseAttributes as $attribute) {
                $default = $attribute->getDefaultValue();
                if ($default != '') {
                    $this->getBrowse()->setData($attribute->getAttributeCode(), $default);
                }
            }
        }
        
        $attributeSetId = $this->getBrowse()->getResource()->getEntityType()->getDefaultAttributeSetId();
        
        // $attributeSetId = 21;
        
        $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
        ->setAttributeSetFilter($attributeSetId)
        ->setSortOrder()
        ->load();
        
        $defaultGroupId = 0;
        foreach ($groupCollection as $group) {
            if ($defaultGroupId == 0 or $group->getIsDefault()) {
                $defaultGroupId = $group->getId();
            }
            
        }	
        
        
        foreach ($groupCollection as $group) {
            $attributes = array();
            foreach ($browseAttributes as $attribute) {
                if ($this->getBrowse()->checkInGroup($attribute->getId(),$attributeSetId, $group->getId())) {
                    $attributes[] = $attribute;
                }
            }
            
            if (!$attributes) {
                continue;
            }
            
            $active = $defaultGroupId == $group->getId();
            $block = $this->getLayout()->createBlock('browse/adminhtml_browse_edit_tab_attributes')
                ->setGroup($group)
                ->setAttributes($attributes)
                ->setAddHiddenFields($active)
                ->toHtml();
            $this->addTab('group_' . $group->getId(), array(
                'label'     => Mage::helper('browse')->__($group->getAttributeGroupName()),
                'content'   => $block,
                'active'    => $active
            ));
        }
        return parent::_beforeToHtml();
    }
    

}
