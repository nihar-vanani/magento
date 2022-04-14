<?php

class Nv_Product_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('product')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('product/product')->load($id);
      $fieldset->addField('productId', 'text', array(
          'label'     => Mage::helper('product')->__('Id'),
          'readonly' => true,
          'name'      => 'productId',
          'value' => $model->getData('productId'),
      ));
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('product')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));
      $fieldset->addField('sku', 'text', array(
          'label'     => Mage::helper('product')->__('SKU'),          
          'name'      => 'sku',
          'value' => $model->getData('sku'),
      ));        
      $fieldset->addField('price', 'text', array(
          'label'     => Mage::helper('product')->__('Price'),          
          'name'      => 'price',
          'value' => $model->getData('price'),
      ));
      $fieldset->addField('quantity', 'text', array(
          'label'     => Mage::helper('product')->__('Quantity'),          
          'name'      => 'quantity',
          'value' => $model->getData('quantity'),
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('product')->__('status'),          
          'name'      => 'status',
          'values' => array('1'=>'Enable','2' => 'Disable'),

      ));
      
      if ( Mage::registry('product_data') ) {
          $form->setValues(Mage::registry('product_data')->getData());
      }
      return parent::_prepareForm();
  }
}