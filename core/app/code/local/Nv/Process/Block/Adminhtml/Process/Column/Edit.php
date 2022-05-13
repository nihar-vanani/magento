<?php 
class Nv_Process_Block_Adminhtml_Process_Column_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_process_column';
		$this->_blockGroup = 'process';
		$this->_headerText = 'Edit Process Column';
		parent::__construct();
	}
}