<?php

class Nv_Process_Block_Adminhtml_Process_Upload_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
 {
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('process_form', array('legend'=>Mage::helper('process')->__('Process information')));

        $fieldset->addField('file_name', 'file', array(
            'label' => Mage::helper('process')->__('File'),
            'class' => 'required-entry',
            'name' => 'file_name',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getProData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProData());
            Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('current_process_media') ) {
            $form->setValues(Mage::registry('current_process_media')->getData());
        }
        return parent::_prepareForm();
    }
 }