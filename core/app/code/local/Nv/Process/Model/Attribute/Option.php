<?php
class Nv_Process_Model_Attribute_Option extends Nv_Process_Model_Process_Abstract
{
	protected $optionArray = [];

	protected function _construct()
    {
        $this->_init('eav/attribute_option');
    }

	public function getIdentifier($row)
	{
		return $row['attribute_code'];
	}

	public function prepareRow($row)
	{
		return [
			'attribute_code' => $row['attribute_code'],
			'values' => $this->optionArray[$row['attribute_code']]
		];
	}


	public function validateRow($row)
	{
		$this->prepareOptionArray($row);
		$this->validateCode($row);
		$this->validateOption($row);
		return $row;
	}

	public function validateOption($row)
	{
		$optionValues = [];
        $attribute = Mage::getSingleton('eav/config')
        ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $row['attribute_code']);

        if ($attribute->usesSource()) 
        {
            $options = $attribute->getSource()->getAllOptions(false);
            foreach ($options as $key => $value) 
            {
                array_push($optionValues,$value['label']);
            }
        }
        $optionValuesArray = array_flip($optionValues);
        if(array_key_exists($row['option'] , $optionValuesArray)){
		    throw new Exception("Duplicate Option.", 1);       
        }
	}

	public function validateCode($row)
	{
		$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $row['attribute_code']);
		if (!$attribute->getId()) {
			throw new Exception("Invalid attribute code", 1);
		}
	}

	public function prepareOptionArray($row)
	{
		$this->optionArray[$row['attribute_code']] = [];
		$this->optionArray[$row['attribute_code']][$row['option_order']] = $row['option'];
		return $row;
	}

	public function importEntries($entries)
    {
        $installer = new Mage_Eav_Model_Entity_Setup('core_setup');
        foreach ($entries as $key => $row) {
			$row = json_decode($row['data'], true);
			$attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $row['attribute_code']);
			Mage::log($row, null, "d.log", true);
			Mage::log($attribute->getId(), null, "f.log", true);
			$installer->addAttributeOption([
				'attribute_id' => $attribute->getId(),
				'values' => $row['values']
			]); 
           
        }
        return true;
    }
}
