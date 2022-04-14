<?php

class Nv_Category_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('category')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('category/category')->load($id);
      $fieldset->addField('parentId', 'text', array(
          'label'     => Mage::helper('category')->__('Parent Id'),          
          'name'      => 'parentId',
          'value' => $model->getData('parentId'),
      ));        
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('category')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));
      $fieldset->addField('path', 'text', array(
          'label'     => Mage::helper('category')->__('Path'),          
          'name'      => 'path',
          'value' => $model->getData('path'),
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('category')->__('Status'),          
          'name'      => 'status',
          'values' => array('1'=>'Enable','2' => 'Disable'),

      ));
      
      if ( Mage::registry('category_data') ) {
          $form->setValues(Mage::registry('category_data')->getData());
      }
      return parent::_prepareForm();
  }
}