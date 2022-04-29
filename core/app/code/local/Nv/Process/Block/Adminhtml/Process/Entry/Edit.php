<?php 
class Nv_Process_Block_Adminhtml_Process_Entry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process_entry';
		$this->_blockGroup = 'process';
		$this->_headerText = 'Edit Process';
		parent::__construct();
	}
}