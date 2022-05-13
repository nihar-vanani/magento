<?php

class Nv_Product_Block_Adminhtml_Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('product')->__('information')));

      $model = Mage::registry('product_data');
      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('product')->__('Category'),          
          'name'      => 'category_id',
          'values' => $this->selectPaths(),
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

  public function selectPaths()
    {
        $categories = Mage::getModel('category/category')->getCollection()->getItems();
        $optionArray = [];
        $optionArray['root'] = array('value'=>0 ,'label'=>'Root Category');

        $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` ORDER BY `path`");
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