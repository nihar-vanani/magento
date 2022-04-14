<?php

class Nv_Vendor_Block_Adminhtml_Vendor_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('vendorGrid');
		$this->setDefaultSort('vendorId');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('vendor/vendor')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('vendorId', array(
		  'header'    => Mage::helper('vendor')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'vendorId',
		));   

		$this->addColumn('firstName', array(
		  'header'    => Mage::helper('vendor')->__('First Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'firstName',
		));   

		$this->addColumn('lastName', array(
		  'header'    => Mage::helper('vendor')->__('Last Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'lastName',
		));   

		$this->addColumn('email', array(
		  'header'    => Mage::helper('vendor')->__('Email'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'email',
		));

		$this->addColumn('action',
		    array(
		        'header'    =>  Mage::helper('vendor')->__('Action'),
		        'width'     => '100',
		        'type'      => 'action',
		        'getter'    => 'getId',
		        'actions'   => array(
		            array(
		                'caption'   => Mage::helper('vendor')->__('Edit'),
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
        $this->setMassactionIdField('vendorId');
        $this->getMassactionBlock()->setFormFieldName('vendor');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vendor')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vendor')->__('Are you sure?')
        ));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}