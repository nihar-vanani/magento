<?php 
class Nv_Process_Block_Adminhtml_Process_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process_group';
		$this->_blockGroup = 'process';
		$this->_headerText = Mage::helper('process')->__('Manage Process Group');
		$this->_addButtonLabel = Mage::helper('process')->__('Add New Group');
		parent::__construct();
	}
}