<?php
class Nv_Process_Model_Process extends Mage_Core_Model_Abstract
{
	const TYPE_ID_IMPORT = "1";
	const TYPE_ID_EXPORT = "2";
	const TYPE_ID_CRON = "3";

	public function _construct()
	{
		$this->_init('process/process');
	}

}