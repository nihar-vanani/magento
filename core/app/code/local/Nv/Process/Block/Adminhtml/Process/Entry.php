<?php 
class Nv_Process_Block_Adminhtml_Process_Entry extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process_entry';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Manage Process Entry');
		$this->_addButtonLabel = Mage::helper('process')->__('Add New Entry');
		parent::__construct();
	}
}