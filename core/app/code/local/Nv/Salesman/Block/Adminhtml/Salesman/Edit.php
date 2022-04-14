<?php

class Nv_Salesman_Block_Adminhtml_Salesman_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {

        $this->_objectId = 'salesmanId';
        $this->_blockGroup = 'salesman';
        $this->_controller = 'adminhtml_salesman';

        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('salesman')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('salesman')->__('Delete'));

    }
}