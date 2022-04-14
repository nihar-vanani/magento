<?php

class Nv_Product_Block_Adminhtml_Product_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('productGrid');
		$this->setDefaultSort('productId');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('product/product')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('productId', array(
		  'header'    => Mage::helper('product')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'productId',
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

		$this->addColumn('createdAt', array(
		  'header'    => Mage::helper('product')->__('CreatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'createdAt',
		));

		$this->addColumn('updatedAt', array(
		  'header'    => Mage::helper('product')->__('UpdatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'updatedAt',
		));

		$this->addColumn('action',
		    array(
		        'header'    =>  Mage::helper('product')->__('Action'),
		        'width'     => '100',
		        'type'      => 'action',
		        'getter'    => 'getId',
		        'actions'   => array(
		            array(
		                'caption'   => Mage::helper('product')->__('Edit'),
		                'url'       => array('base'=> '*/*/edit'),
		                'field'     => 'id'
		            )
		        ),
		        'filter'    => false,
		        'sortable'  => false,
		        'index'     => 'stores',
		        'is_system' => true,
		));

		return parent::_prepareColumns();
	}   

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productId');
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