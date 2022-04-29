<?php
class Nv_Process_Block_Adminhtml_Process_Entry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function getProcessOptions()
  {
      $processModel = Mage::getModel('process/process');
      $select = $processModel->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['value' => 'process_id','label' => 'name'])
                ->order('name ASC');
      $processOptions = $processModel->getResource()->getReadConnection()->fetchAll($select);
      if ($processOptions) {
        return $processOptions;
      }
      return [];
  }

  protected function _prepareForm()
  {

      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));

      $model = Mage::registry('process_data');
      
      $fieldset->addField('process_id', 'select',
            array(
                'name'  => 'process_id',
                'label' => Mage::helper('process')->__('Process Id'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->getProcessOptions()
            )
        );

      $fieldset->addField('identifier', 'text', array(
          'label'     => Mage::helper('process')->__('Identifier'),          
          'name'      => 'identifier',
          'value' => $model->getData('identifier'),
      ));

      $fieldset->addField('start_time', 'text', array(
          'label'     => Mage::helper('process')->__('Start Time'),          
          'name'      => 'start_time',
          'value' => $model->getData('start_time'),
      ));

      $fieldset->addField('end_time', 'text', array(
          'label'     => Mage::helper('process')->__('End Time'),          
          'name'      => 'end_time',
          'value' => $model->getData('end_time'),
      ));

      $fieldset->addField('data', 'text', array(
          'label'     => Mage::helper('process')->__('Data'),          
          'name'      => 'data',
          'value' => $model->getData('data'),
      ));

      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}