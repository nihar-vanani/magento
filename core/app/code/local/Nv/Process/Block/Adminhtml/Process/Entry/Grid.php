<?php
class Nv_Process_Block_Adminhtml_Process_Entry_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('process/process_entry')->getCollection();
	    foreach ($collection->getItems() as $data) 
	    {
	    	$data->process_id = Mage::getModel('process/process')->load($data->process_id)->name;
	    }
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('entry_id', array(
	        'header' => Mage::helper('process')->__('Entry Id'),
	        'index' => 'entry_id',
	    ));

	    $this->addColumn('process_id', array(
	        'header' => Mage::helper('process')->__('Process Name'),
	        'align' => 'right',
	        'index' => 'process_id',
	    ));
	    $this->addColumn('identifier', array(
	        'header' => Mage::helper('process')->__('Identifier'),
	        'align' => 'right',
	        'index' => 'identifier',
	    ));
	    $this->addColumn('start_time', array(
	        'header' => Mage::helper('process')->__('Start Time'),
	        'align' => 'right',
	        'index' => 'start_time',
	    ));
	    $this->addColumn('end_time', array(
	        'header' => Mage::helper('process')->__('End Time'),
	        'align' => 'right',
	        'index' => 'end_time',
	    ));
	    $this->addColumn('data', array(
	        'header' => Mage::helper('process')->__('Data'),
	        'align' => 'right',
	        'index' => 'data',
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