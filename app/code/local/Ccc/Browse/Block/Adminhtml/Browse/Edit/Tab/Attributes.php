<?php

class Ccc_Browse_Block_Adminhtml_Browse_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Widget_Form
{
    public function getBrowse()
    {
        return Mage::registry('current_browse');
    }

    protected function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        parent::_prepareLayout();
           
    }

    public function _prepareForm()
    {
        $group = $this->getGroup();
        $attributes = $this->getAttributes();

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $form->setDataObject($this->getVendor());
        $form->setHtmlIdPrefix('group_' . $group->getId());
        $form->setFieldNameSuffix('browse');
        $fieldset = $form->addFieldset('fieldset_group_' . $group->getId(), array(
            'legend'    => Mage::helper('browse')->__($group->getAttributeGroupName()),
            'class'     => 'fieldset',
        ));


        $this->_setFieldset($attributes, $fieldset);

        $form->addValues($this->getBrowse()->getData());

        return parent::_prepareForm();
    }
}

?>