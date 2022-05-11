<?php
class Nv_Process_Model_Product extends Nv_Process_Model_Process_Abstract
{
	protected function _construct()
    {
        $this->_init('product/product');
    }

	public function getIdentifier($row)
	{
		return $row['name'];
	}

	public function prepareRow($row)
	{
		return [
			'name' => $row['name'],
			'sku' => $row['sku'],
			'price' => $row['price'],
			'quantity' => $row['quantity'],
			'link' => $row['link'],
			'status' => $row['status'],
		];

	}

	public function validateRow($row)
	{
		return $row;
	}

}