<?php

class Nv_Salesman_Block_Adminhtml_Salesman_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('salesmanGrid');
		$this->setDefaultSort('salesmanId');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('salesman/salesman')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('salesmanId', array(
		  'header'    => Mage::helper('salesman')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'salesmanId',
		));   

		$this->addColumn('firstName', array(
		  'header'    => Mage::helper('salesman')->__('First Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'firstName',
		));   

		$this->addColumn('lastName', array(
		  'header'    => Mage::helper('salesman')->__('Last Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'lastName',
		));   

		$this->addColumn('email', array(
		  'header'    => Mage::helper('salesman')->__('Email'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'email',
		));

		$this->addColumn('mobile', array(
		  'header'    => Mage::helper('salesman')->__('Mobile'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'mobile',
		));

		$this->addColumn('percentage', array(
		  'header'    => Mage::helper('salesman')->__('Percentage(%)'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'percentage',
		));

		$this->addColumn('status', array(
          'header'    => Mage::helper('salesman')->__('status'),
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
		  'header'    => Mage::helper('salesman')->__('CreatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'createdAt',
		));

		$this->addColumn('updatedAt', array(
		  'header'    => Mage::helper('salesman')->__('UpdatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'updatedAt',
		));

		$this->addColumn('action',
		    array(
		        'header'    =>  Mage::helper('salesman')->__('Action'),
		        'width'     => '100',
		        'type'      => 'action',
		        'getter'    => 'getId',
		        'actions'   => array(
		            array(
		                'caption'   => Mage::helper('salesman')->__('Edit'),
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
        $this->setMassactionIdField('salesmanId');
        $this->getMassactionBlock()->setFormFieldName('salesman');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
        ));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}