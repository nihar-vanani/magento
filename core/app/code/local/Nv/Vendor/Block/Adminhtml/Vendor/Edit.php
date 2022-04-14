<?php

class Nv_Vendor_Block_Adminhtml_Vendor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {

        $this->_objectId = 'vendorId';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_vendor';

        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('vendor')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('vendor')->__('Delete'));

    }

}