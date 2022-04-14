<?php

class Nv_Product_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {

        $this->_objectId = 'productId';
        $this->_blockGroup = 'product';
        $this->_controller = 'adminhtml_product';

        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('product')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('product')->__('Delete'));

    }

}