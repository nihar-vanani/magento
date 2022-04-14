<?php
class Nv_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_product';
    $this->_blockGroup = 'product';
    $this->_headerText = Mage::helper('product')->__('Manager');
    $this->_addButtonLabel = Mage::helper('product')->__('Add Item');
    parent::__construct();

  }
}