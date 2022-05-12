<?php
class Nv_Process_Model_Product extends Nv_Process_Model_Process_Abstract
{
	protected $existingCategories = [];
	protected $existingSku = [];

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
			'category_id' => $row['category_id'],
			'sku' => $row['sku'],
			'price' => $row['price'],
			'quantity' => $row['quantity'],
			'link' => $row['link'],
			'status' => $row['status'],
		];

	}

	public function validateRow($row)
	{
		if (!$this->existingCategories) {
			$this->getCategories();
		}
		$this->getExistingSku();
		if (!array_key_exists($row['category_id'], $this->existingCategories)) {
			throw new Exception("Invalid Category.");
		}
		$row['category_id'] = $this->existingCategories[$row['category_id']];

		if (in_array($row['sku'], $this->existingSku)) {
			throw new Exception("Duplicate Sku.");
		}
		$this->existingSku[] = $row['sku'];

		if ($row['status'] == "yes") {
			$row['status'] = 1;
		}
		else{
			$row['status'] = 2;
		}
		return $row;
	}

	public function getCategories()
    {
        $categories = Mage::getModel('category/category')->getCollection()->getItems();
        $optionArray = [];
        $optionArray['Root'] = 0;

        $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` ORDER BY `path`");
        foreach ($categories as $category) 
        {
            foreach ($allPath as $categoryPath)
            {
                if($category->_getData('category_id') == $categoryPath['category_id'])
                {
                    $category_id = $category->_getData('category_id');
                    $path = $category->getPath();
                    $optionArray[$path] = $category_id;
                }
            }
        }
        $this->existingCategories = $optionArray;
    }

	public function getExistingSku()
	{
		$model = Mage::getModel('product/product');
		$select = $model->getCollection()->getSelect()
						->reset(Zend_Db_Select::COLUMNS)
						->columns(['sku']);
		$sku = $model->getResource()->getReadConnection()->fetchAll($select);
		$this->existingSku = $sku;
	}

	public function importEntries($entries)
    {
        $product = Mage::getModel('product/product');
        foreach ($entries as $key => $value) {
            $date = date('Y-m-d H:i:s');
            $product->setData(json_decode($value['data'], true));
            $product->setcreatedDate($date);
            $product->save();
        }
        return true;
    }
}
