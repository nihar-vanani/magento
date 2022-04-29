<?php
class Nv_Process_Block_Adminhtml_Process_Column_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('process')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));

      $fieldset->addField('casting_type', 'select',
            array(
                'name'  => 'casting_type',
                'label' => Mage::helper('process')->__('Casting Type'),
                'class' => 'required-entry',
                'required' => true,
                'values' => [
                  ['value' => Nv_Process_Model_Process_Column::TYPE_INTEGER, 'label' => Mage::helper('process')->__('integer')],
                  ['value' => Nv_Process_Model_Process_Column::TYPE_FLOAT, 'label' => Mage::helper('process')->__('float')],
                  ['value' => Nv_Process_Model_Process_Column::TYPE_DECIMAL, 'label' => Mage::helper('process')->__('decimal')],
                  ['value' => Nv_Process_Model_Process_Column::TYPE_DATETIME, 'label' => Mage::helper('process')->__('datetime')],
                  ['value' => Nv_Process_Model_Process_Column::TYPE_TEXT, 'label' => Mage::helper('process')->__('text')],
                  ['value' => Nv_Process_Model_Process_Column::TYPE_VARCHAR, 'label' => Mage::helper('process')->__('varchar')]
                ]
            )
        );

      $fieldset->addField('required', 'select',
            array(
                'name'  => 'required',
                'label' => Mage::helper('process')->__('Is Required'),
                'class' => 'required-entry',
                'required' => true,
                'values' => [
                  ['value' => Nv_Process_Model_Process_Column::REQUIRED_TRUE, 'label' => Mage::helper('process')->__('Yes')],
                  ['value' => Nv_Process_Model_Process_Column::REQUIRED_FALSE, 'label' => Mage::helper('process')->__('No')]
                ]
            )
        );

      $fieldset->addField('exception', 'select',
            array(
                'name'  => 'exception',
                'label' => Mage::helper('process')->__('Exception'),
                'class' => 'required-entry',
                'required' => true,
                'values' => [
                  ['value' => Nv_Process_Model_Process_Column::EXCEPTION_TRUE, 'label' => Mage::helper('process')->__('Yes')],
                  ['value' => Nv_Process_Model_Process_Column::EXCEPTION_FALSE, 'label' => Mage::helper('process')->__('No')]
                ]
            )
        );

      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}