<?php
class Nv_Process_Block_Adminhtml_Process_Column_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('process/process_column')->getCollection();
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	    $this->addColumn('process_id', array(
	        'header' => Mage::helper('process')->__('Process Id'),
	        'align' => 'right',
	        'index' => 'process_id',
	    ));
	    $this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Name'),
	        'align' => 'right',
	        'index' => 'name',
	    ));

	    $this->addColumn('required', array(
				'header' => Mage::helper('process')->__('Required'),
				'index' => 'required',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('Yes'),
	                2 => Mage::helper('process')->__('No'),
	            ),
		));

	    $this->addColumn('casting_type', array(
				'header' => Mage::helper('process')->__('Casting Type'),
				'index' => 'casting_type',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('integer'),
	                2 => Mage::helper('process')->__('float'),
	                3 => Mage::helper('process')->__('decimal'),
	                4 => Mage::helper('process')->__('datetime'),
	                5 => Mage::helper('process')->__('text'),
	                6 => Mage::helper('process')->__('varchar'),
	            ),
		));

	    $this->addColumn('exception', array(
				'header' => Mage::helper('process')->__('Exception'),
				'index' => 'exception',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('Yes'),
	                2 => Mage::helper('process')->__('No'),
	            ),
		));
	    
	    $this->addColumn('created_date', array(
	        'header' => Mage::helper('process')->__('Created Date'),
	        'align' => 'right',
	        'index' => 'created_date',
	    ));
	    $this->addColumn('updated_date', array(
	        'header' => Mage::helper('process')->__('Updated Date'),
	        'align' => 'right',
	        'index' => 'updated_date',
	    ));

	    $this->addColumn('action',
		    array(
		        'header'    =>  Mage::helper('process')->__('Action'),
		        'width'     => '100',
		        'type'      => 'action',
		        'getter'    => 'getId',
		        'actions'   => array(
		            array(
		                'caption'   => Mage::helper('process')->__('Edit'),
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

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}