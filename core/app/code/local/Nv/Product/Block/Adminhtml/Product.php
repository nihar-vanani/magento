<?php
class Nv_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_product';
    $this->_blockGroup = 'product';
    $this->_headerText = Mage::helper('product')->__('Manage Product');
    $this->_addButtonLabel = Mage::helper('product')->__('Add New Product');
    parent::__construct();
  }
}