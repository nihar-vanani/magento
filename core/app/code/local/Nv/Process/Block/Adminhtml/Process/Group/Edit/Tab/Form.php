<?php
class Nv_Process_Block_Adminhtml_Process_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('process/process_group')->load($id);
      
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('process')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));

      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}