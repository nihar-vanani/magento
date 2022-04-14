<?php

class Nv_Category_Block_Adminhtml_Category_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('categoryGrid');
		$this->setDefaultSort('categoryId');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('category/category')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('categoryId', array(
		  'header'    => Mage::helper('category')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'categoryId',
		)); 

		$this->addColumn('parentId', array(
		  'header'    => Mage::helper('category')->__('Parent ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'parentId',
		));  

		$this->addColumn('name', array(
		  'header'    => Mage::helper('category')->__('Name'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'name',
		));   

		$this->addColumn('path', array(
		  'header'    => Mage::helper('category')->__('Path'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'path',
		));   

		$this->addColumn('status', array(
          'header'    => Mage::helper('category')->__('Status'),
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
		  'header'    => Mage::helper('category')->__('CreatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'createdAt',
		));

		$this->addColumn('updatedAt', array(
		  'header'    => Mage::helper('category')->__('UpdatedAt'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'updatedAt',
		));

		$this->addColumn('action',
		    array(
		        'header'    =>  Mage::helper('category')->__('Action'),
		        'width'     => '100',
		        'type'      => 'action',
		        'getter'    => 'getId',
		        'actions'   => array(
		            array(
		                'caption'   => Mage::helper('category')->__('Edit'),
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
        $this->setMassactionIdField('categoryId');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}