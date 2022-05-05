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
	    foreach ($collection->getItems() as $data) 
	    {
	    	$data->process_id = Mage::getModel('process/process')->load($data->process_id)->name;
	    }
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{ 
		$this->addColumn('column_id', array(
	        'header' => Mage::helper('process')->__('Column Id'),
	        'index' => 'column_id',
	    ));

	    $this->addColumn('process_id', array(
	        'header' => Mage::helper('process')->__('Process Name'),
	        'align' => 'right',
	        'index' => 'process_id',
	    ));
	    $this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Name'),
	        'align' => 'right',
	        'index' => 'name',
	    ));

	    $this->addColumn('sample_value', array(
	        'header' => Mage::helper('process')->__('Sample Value'),
	        'align' => 'right',
	        'index' => 'sample_value',
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
	                2 => Mage::helper('process')->__('varchar'),
	                3 => Mage::helper('process')->__('decimal'),
	                4 => Mage::helper('process')->__('datetime'),
	                5 => Mage::helper('process')->__('text'),
	                6 => Mage::helper('process')->__('float')
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

	    return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('column_id');
        $this->getMassactionBlock()->setFormFieldName('column');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('process')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('process')->__('Are you sure?')
        ));
    }

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}