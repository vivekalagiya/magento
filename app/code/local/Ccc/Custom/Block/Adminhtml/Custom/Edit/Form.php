<?php

class Ccc_Custom_Block_Adminhtml_Custom_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post'
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'Custom_form', 
            array('lagend' => Mage::helper('custom')->__('Custom information'))
        );

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('custom')->__('First Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'first_name',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('custom')->__('Last Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'last_name',
        ));
        //Edit
        if (Mage::getSingleton('adminhtml/session')->getCustomData()) {
            $form->setValues(Mage::getSingleton('adminhml/session')->getCustomData());
            Mage::getSingleton('adminhtml/session')->setCustomData(null);
        } elseif (Mage::registry('custom_data')) {
            $form->setValues(Mage::registry('custom_data')->getData());
        }
        return parent::_prepareForm();
    }
}
