<?php 
class Nv_Process_Block_Adminhtml_Process extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Manage Process');
		$this->_addButtonLabel = Mage::helper('process')->__('Add New Process');
		parent::__construct();
	}
}