<?php 
class Nv_Vendor_Block_Adminhtml_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
		$this->_controller = 'adminhtml_vendor';
		$this->_blockGroup = 'vendor';
		$this->_headerText = 'Manage Vendor';
		parent::__construct();
	}
}