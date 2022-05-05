<?php
class Nv_Process_Model_Category extends Nv_Process_Model_Process_Abstract
{
	protected function _construct()
    {
        $this->_init('category/category');
    }

	public function getIdentifier($row)
	{
		return $row['name'];
	}

	public function prepareRow($row)
	{
		return [
			'name' => $row['name'],
			'path' => $row['path']
		];
	}

	public function validateRow($row)
	{
		return $row;
	}
}