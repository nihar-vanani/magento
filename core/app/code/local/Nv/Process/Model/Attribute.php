<?php
class Nv_Process_Model_Attribute extends Nv_Process_Model_Process_Abstract
{
	const LABEL_TRUE = "true";
	const LABEL_FALSE = "false";

	protected function _construct()
    {
        $this->_init('eav/entity_attribute');
    }

	public function getIdentifier($row)
	{
		return $row['code'];
	}

	public function prepareRow($row)
	{
		return $row;
	}


	public function validateRow($row)
	{
		$this->validateValue($row);
		return $row;
	}

	public function validateValue(&$row)
	{
		foreach ($row as $key => $value) {
			if ($key == 'visible' || $key == 'required' || $key == 'global' || $key == 'user_defined') {
				if (strtolower($row[$key]) == self::LABEL_TRUE || strtolower($row[$key]) == self::LABEL_FALSE) {
					$row[$key] = strtolower($row[$key]);
					//return $row;
				}
				else{
					throw new Exception("Invalid value of ".$row[$key]);
				}
			}
		}
	}	

	public function importEntries($entries)
    {
        $installer = new Mage_Catalog_Model_Resource_Setup('core_setup');
        foreach ($entries as $key => $row) {
           $row = json_decode($row['data'], true);
           $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $row['code'], array(
			    'group'         => $row['group'],
			    'attribute_set' => $row['attribute_set'],
			    'label'         => $row['label'],
			    'type'          => $row['type'],
			    'input'         => $row['input'],
			    'visible'       => ($row['visible'] == "true") ? true : false,
			    'required'      => ($row['required'] == "true") ? true : false,
			    'user_defined'  => ($row['user_defined'] == "true") ? true : false
			));
        }
        return true;
    }
}
