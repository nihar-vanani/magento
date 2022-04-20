<?php
class Nv_Vendor_Model_Resource_Vendor_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{   
    protected function _construct()
    {      
        $this->_init('vendor/vendor');
    }

}