<?php
class Nv_Process_Model_Attribute extends Nv_Process_Model_Process_Abstract
{
	protected $entityTypes = [];
	protected $attributeCodes = [];

	protected function _construct()
    {
        $this->_init('eav/entity_attribute');
    }

	public function getIdentifier($row)
	{
		return $row['attribute_code'];
	}

	public function prepareRow($row)
	{
		return $row;
	}

	public function validateRow($row)
	{
		$row['entity_type_id'] = $this->validateEntityType($row['entity_type_id']);
		$row = $this->validateAttributeCode($row);
		$this->attributeCodes[$row['attribute_code']] = $row['entity_type_id'];
		return $row;
	}

	public function validateEntityType($entityType)
	{
		if (!$this->entityTypes) {
			$entity = Mage::getModel('eav/entity_type');
			$select = $entity->getCollection()
		                ->getSelect()
		                ->reset(Zend_Db_Select::COLUMNS)
		                ->columns(['entity_type_code', 'entity_type_id']);
		    $pairs = $entity->getResource()->getReadConnection()->fetchPairs($select);
		    $this->entityTypes = $pairs;
		}
		
		if (!array_key_exists($entityType, $this->entityTypes)) {
			throw new Exception("Invalid entity type.", 1);
		}
		return $this->entityTypes[$entityType];
	}

	public function validateAttributeCode($row)
	{
		if (!$this->attributeCodes) {
			$entityType = Mage::getModel('eav/entity_attribute');
			$select = $entityType->getCollection()
		                ->getSelect()
		                ->reset(Zend_Db_Select::COLUMNS)
		                ->columns(['attribute_code', 'entity_type_id']);
		    $pairs = $entityType->getResource()->getReadConnection()->fetchPairs($select);
		    $this->attributeCodes = $pairs;
		}

		if (array_key_exists($row['attribute_code'], $this->attributeCodes)) {
			if ($row['entity_type_id'] == $this->attributeCodes[$row['attribute_code']]) {
				throw new Exception("Duplicate Code", 1);
			}
		}
		return $row;
	}

	public function importEntries($entries)
    {
        $attribute = Mage::getModel('eav/entity_attribute');
        foreach ($entries as $key => $row) {
            $row = json_decode($row['data'], true);
            $attribute->setData($row);
            $attribute->save();
        }
        return true;
    }
}
