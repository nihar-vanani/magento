<?php
class Nv_Process_Model_Category extends Nv_Process_Model_Process_Abstract
{
	protected $existingCategories = [];

	protected function _construct()
    {
        $this->_init('category/category');
    }

	public function getIdentifier($row)
	{
		return $row['path'];
	}

	public function prepareRow($row)
	{
		return [
			'name' => $row['name'],
			'parent_id' => $row['parent_id'],
			'path' => $row['path'],
			'description' => $row['description'],
			'link' => $row['link'],
			'status' => $row['status'],
		];

	}

	public function validateRow($row)
	{
		if (!$this->existingCategories) {
			$this->getCategories();
		}
		$row = $this->validateValue($row);
		return $row;
	}

	public function validateValue($row)
	{
		$row['parent_id'] = $this->getParent($row);
		$this->validateParent($row['parent_id']);
		$row['name'] = $this->getName($row);
		$this->validateName($row['name']);
		if (!array_key_exists($row['path'], $this->existingCategories)) {
			$this->existingCategories[$row['path']] = 0;
		}



		if ($row['parent_id'] == "Root") {
			$row['parent_id'] = 0;
		}
		else{
			if(array_key_exists($row['parent_id'], $this->existingCategories)){
				$row['parent_id'] = $this->existingCategories[$row['parent_id']];
			}
		}

		if ($row['status'] == "Yes") {
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

    public function getName($row)
    {
    	$array = explode("/", $row['path']);
    	if (count($array) == 1) {
    		return $row['path'];
    	}
    	return array_pop($array);
    }

    public function getParent($row)
    {
    	$array = explode("/", $row['path']);
    	if (count($array) == 1) {
    		return "Root";
    	}
    	array_pop($array);
    	return implode("/", $array);
    }

    public function validateName($name)
    {
    	if (array_key_exists($name, $this->existingCategories)) {
    		throw new Exception("Duplicate Name", 1);
    	}
    }

    public function validateParent($name)
    {
    	if (!array_key_exists($name, $this->existingCategories)) {
    		throw new Exception("No Parent", 1);
    	}
    }

    public function importEntries($entries)
    {
        foreach ($entries as $key => $row) {
            $row = json_decode($row['data'], true);
            $row['created_at'] = date('Y-m-d_H-i-s');
            $this->setData($row);
            $this->save();
            $this->updatePath($this->getData());
        }
    }

    public function updatePath($entry)
    {
    	$category = Mage::getModel('category/category');
    	if ($entry['parent_id'] == 0)
    	{
	    	if ($entry['name'] == $entry['path']) {
	    		$parentId = 0;
	    		$path = $entry['category_id'];
				Mage::log($row, null, "g.log", true);
	    	}
	    	else{
	    		$parent = $this->getParent($entry);
	    		$this->getCategories();
	    		$id = $this->existingCategories[$parent];
	    		$select = $category->getCollection()
		                ->getSelect()
		                ->where('category_id = '.$id);
		        $row = $category->getResource()->getReadConnection()->fetchRow($select);
		        $path = $row['path']."/".$entry['category_id'];
		        $parentId = $row['category_id'];
	    	}
    	}
    	else{
			$select = $category->getCollection()
		                ->getSelect()
		                ->where('category_id = '.$entry['parent_id']);
			$row = $category->getResource()->getReadConnection()->fetchRow($select);
			$path = $row['path']."/".$entry['category_id'];
			$parentId = $row['category_id'];
    	}
		$query = "UPDATE `category` SET `path` = '{$path}', `parent_id` = '{$parentId}' WHERE `category_id` = '{$entry['category_id']}'";
        	$category->getResource()->getReadConnection()->fetchAll($query);
        	return true;
    }
}
