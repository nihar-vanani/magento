<?php

class Nv_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('salesman')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('salesman/salesman')->load($id);
      $fieldset->addField('firstName', 'text', array(
          'label'     => Mage::helper('salesman')->__('First Name'),          
          'name'      => 'firstName',
          'value' => $model->getData('firstName'),
      ));
      $fieldset->addField('lastName', 'text', array(
          'label'     => Mage::helper('salesman')->__('Last Name'),          
          'name'      => 'lastName',
          'value' => $model->getData('lastName'),
      ));        
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('salesman')->__('Email'),          
          'name'      => 'email',
          'value' => $model->getData('email'),
      ));
      $fieldset->addField('mobile', 'text', array(
          'label'     => Mage::helper('salesman')->__('Mobile'),          
          'name'      => 'mobile',
          'value' => $model->getData('mobile'),
      ));
      $fieldset->addField('percentage', 'text', array(
          'label'     => Mage::helper('salesman')->__('Percentage'),          
          'name'      => 'percentage',
          'value' => $model->getData('percentage'),
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('salesman')->__('Status'),          
          'name'      => 'status',
          'values' => array('1'=>'Enable','2' => 'Disable'),

      ));
      
      if ( Mage::registry('salesman_data') ) {
          $form->setValues(Mage::registry('salesman_data')->getData());
      }
      return parent::_prepareForm();
  }
}