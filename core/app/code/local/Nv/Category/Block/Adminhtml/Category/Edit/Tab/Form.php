<?php

class Nv_Category_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('category')->__('information')));

       $model = Mage::registry('category_data');
      $fieldset->addField('parent_id', 'select', array(
          'label'     => Mage::helper('category')->__('Parent Id'),          
          'name'      => 'parent_id',
          'values' => $this->selectPaths(),
      ));        
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('category')->__('Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));
      $fieldset->addField('path', 'text', array(
          'label'     => Mage::helper('category')->__('Path'),          
          'name'      => 'path',
          'value' => $model->getPath('path'),
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('category')->__('Status'),          
          'name'      => 'status',
          'values' => array('1'=>'Enable','2' => 'Disable'),

      ));
      
      if ( Mage::registry('category_categoryPath') ) {
          $form->setValues(Mage::registry('category_categoryPath')->getData());
      }
      return parent::_prepareForm();
  }

  public function selectPaths()
    {
        $id = $this->getRequest()->getParam('id');
        $categories = Mage::getModel('category/category')->getCollection()->getItems();
        $optionArray = [];
        $optionArray['root'] = array('value'=>0 ,'label'=>'Root Category');
        if($id)
        {
            $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` NOT LIKE '%$id%' ");
        }
        else
        {
            $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` ORDER BY `path`");
        }
        foreach ($categories as $category) 
        {
            foreach ($allPath as $categoryPath)
            {
                if($category->_getData('category_id') == $categoryPath['category_id'])
                {
                    $category_id = $category->_getData('category_id');
                    $path = $category->getPath();
                    $array = array('value' => $category_id ,'label' => $path);
                    $optionArray[$category_id]=$array;
                }
            }
        }
        return $optionArray;
    }
}

