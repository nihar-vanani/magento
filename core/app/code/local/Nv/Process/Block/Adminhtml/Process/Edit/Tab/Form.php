<?php
class Nv_Process_Block_Adminhtml_Process_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function getGroupOptions()
  {
      $groupModel = Mage::getModel('process/process_group');
      $select = $groupModel->getCollection()
                ->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns(['value' => 'group_id','label' => 'name'])
                ->order('name ASC');
      $groupOptions = $groupModel->getResource()->getReadConnection()->fetchAll($select);
      if ($groupOptions) {
        return $groupOptions;
      }
      return [];
  }

  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));
     
      $model = Mage::registry('process_data');
      
      $fieldset->addField('group_id', 'select',
            array(
                'name'  => 'group_id',
                'label' => Mage::helper('process')->__('Group Id'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->getGroupOptions()
            )
        );

      $fieldset->addField('type_id', 'select',
            array(
                'name'  => 'type_id',
                'label' => Mage::helper('process')->__('Type Id'),
                'class' => 'required-entry',
                'required' => true,
                'values' => [
                  ['value' => Nv_Process_Model_Process::TYPE_ID_IMPORT, 'label' => Mage::helper('process')->__('Import')],
                  ['value' => Nv_Process_Model_Process::TYPE_ID_EXPORT, 'label' => Mage::helper('process')->__('Export')],
                  ['value' => Nv_Process_Model_Process::TYPE_ID_CRON, 'label' => Mage::helper('process')->__('Cron')],
                ]
            )
        );

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('process')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));

      $fieldset->addField('per_request_count', 'text', array(
          'label'     => Mage::helper('process')->__('Per Request Count'),          
          'name'      => 'per_request_count',
          'value' => $model->getData('per_request_count'),
      ));

      $fieldset->addField('request_interval', 'text', array(
          'label'     => Mage::helper('process')->__('Request Interval'),          
          'name'      => 'request_interval',
          'value' => $model->getData('request_interval'),
      ));

      $fieldset->addField('request_model', 'text', array(
          'label'     => Mage::helper('process')->__('Request Model'),          
          'name'      => 'request_model',
          'value' => $model->getData('request_model'),
      ));

      $fieldset->addField('file_name', 'text', array(
          'label'     => Mage::helper('process')->__('File Name'),          
          'name'      => 'file_name',
          'value' => $model->getData('file_name'),
      ));

      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}