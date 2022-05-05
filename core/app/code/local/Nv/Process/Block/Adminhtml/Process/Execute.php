<?php 
class Nv_Process_Block_Adminhtml_Process_Execute extends Mage_Adminhtml_Block_Widget_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('process/execute.phtml');
	}
}