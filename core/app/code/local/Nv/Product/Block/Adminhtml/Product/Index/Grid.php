<?php

class Nv_Product_Block_Adminhtml_Product_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('product/product')->getCollection();
	  foreach ($collection->getItems() as $data) 
	    {
	    		$category = Mage::getModel('category/category');
	    		$path = $category->load($data->category_id)->path;
	    		$data->category_id = $category->getPath($path);
	    }
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('product_id', array(
		  'header'    => Mage::helper('product')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'product_id',
		));   

		$this->addColumn('category_id', array(
		  'header'    => Mage::helper('product')->__('Category'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'category_id',
		));   

		$this->addColumn('name', array(
		  'header'    => Mage::helper('product')->__('Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'name',
		));   

		$this->addColumn('sku', array(
		  'header'    => Mage::helper('product')->__('SKU'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'sku',
		));   

		$this->addColumn('price', array(
		  'header'    => Mage::helper('product')->__('Price'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'price',
		));

		$this->addColumn('quantity', array(
		  'header'    => Mage::helper('product')->__('Quantity'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'quantity',
		));

		$this->addColumn('status', array(
          'header'    => Mage::helper('product')->__('status'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'status',
          'type'      => 'options',
          'options'    => array(
                                1 => 'Enable',
                                2 => 'Disable'
                            ),
      ));    

		$this->addColumn('created_date', array(
		  'header'    => Mage::helper('product')->__('Created Date'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'created_date',
		));

		$this->addColumn('updated_date', array(
		  'header'    => Mage::helper('product')->__('Updated Date'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'updated_date',
		));

		return parent::_prepareColumns();
	}   

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('product')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('product')->__('Are you sure?')
        ));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}