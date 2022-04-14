<?php

class Nv_Category_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {

        $this->_objectId = 'categoryId';
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';

        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('category')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('category')->__('Delete'));

    }
}