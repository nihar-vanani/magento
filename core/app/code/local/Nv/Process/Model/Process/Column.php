<?php
class Nv_Process_Model_Process_Column extends Mage_Core_Model_Abstract
{
	const REQUIRED_TRUE = "1";
	const EXCEPTION_TRUE = "1";
	const REQUIRED_FALSE = "2";
	const EXCEPTION_FALSE = "2";
    const TYPE_INTEGER          = '1';
    const TYPE_VARCHAR          = '2';
    const TYPE_DECIMAL          = '3';
    const TYPE_DATETIME         = '4';
    const TYPE_TEXT             = '5';
    const TYPE_FLOAT            = '6';

	public function _construct()
	{
		$this->_init('process/process_column');
	}
}