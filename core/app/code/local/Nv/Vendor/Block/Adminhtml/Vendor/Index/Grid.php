<?php

class Nv_Vendor_Block_Adminhtml_Vendor_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('vendorGrid');
		$this->setDefaultSort('entity_id');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('vendor/vendor')->getCollection()
            ->addAttributeToSelect('first_name')
            ->addAttributeToSelect('last_name')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('mobile')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('created_date')
            ->addAttributeToSelect('updated_date');
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('entity_id', array(
		  'header'    => Mage::helper('vendor')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'entity_id',
		));   

		$this->addColumn('first_name', array(
		  'header'    => Mage::helper('vendor')->__('First Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'first_name',
		));   

		$this->addColumn('last_name', array(
		  'header'    => Mage::helper('vendor')->__('Last Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'last_name',
		));

		$this->addColumn('email', array(
		  'header'    => Mage::helper('vendor')->__('Email'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'email',
		));

		$this->addColumn('mobile', array(
		  'header'    => Mage::helper('vendor')->__('Mobile'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'mobile',
		));   

		$this->addColumn('status', array(
          'header'    => Mage::helper('vendor')->__('Status'),
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
		  'header'    => Mage::helper('vendor')->__('Created Date'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'created_date',
		));

		$this->addColumn('updated_date', array(
		  'header'    => Mage::helper('vendor')->__('Updated Date'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'updated_date',
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