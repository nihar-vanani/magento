<?php

class Nv_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('vendor')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('vendor/vendor')->load($id);
      $fieldset->addField('vendorId', 'text', array(
          'label'     => Mage::helper('vendor')->__('Id'),
          'readonly' => true,
          'name'      => 'vendorId',
          'value' => $model->getData('vendorId'),
      ));
      $fieldset->addField('firstName', 'text', array(
          'label'     => Mage::helper('vendor')->__('First Name'),          
          'name'      => 'firstname',
          'value' => $model->getData('firstName'),
      ));
      $fieldset->addField('lastName', 'text', array(
          'label'     => Mage::helper('vendor')->__('Last Name'),          
          'name'      => 'lastname',
          'value' => $model->getData('lastName'),
      ));        
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('vendor')->__('email'),          
          'name'      => 'email',
          'value' => $model->getData('email'),
      ));

      if ( Mage::registry('vendor_data') ) {
          $form->setValues(Mage::registry('vendor_data')->getData());
      }
      return parent::_prepareForm();
  }
}