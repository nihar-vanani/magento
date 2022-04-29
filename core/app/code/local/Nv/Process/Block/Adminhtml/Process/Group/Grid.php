<?php
class Nv_Process_Block_Adminhtml_Process_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('process/process_group')->getCollection();
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	    $this->addColumn('group_id', array(
	        'header' => Mage::helper('process')->__('Group Id'),
	        'align' => 'right',
	        'index' => 'group_id',
	    ));
	    $this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Name'),
	        'align' => 'right',
	        'index' => 'name',
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