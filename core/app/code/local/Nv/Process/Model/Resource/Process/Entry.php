<?php 
class Nv_Process_Model_Resource_Process_Entry extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct()
	{
		$this->_init('process/process_entry','entry_id');
	}
}