<?php 

class Nv_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct() {
		parent::__construct();
	}

	protected function _getStoreId() {
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return $storeId;
	}

	protected function _prepareCollection() {
		$collection = Mage::getModel('vendor/vendor')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('lastname');
		$storeId = $this->_getStoreId();
		$collection->joinAttribute(
			'firstname',
			'vendor/firstname',
			'entity_id',
			null,
			'inner',
			$storeId
		);
		$collection->joinAttribute(
			'lastname',
			'vendor/lastname',
			'entity_id',
			null,
			'inner',
			$storeId
		);
		$collection->joinAttribute(
			'email',
			'vendor/email',
			'entity_id',
			null,
			'inner',
			$storeId
		);
		$collection->joinAttribute(
			'id',
			'vendor/entity_id',
			'entity_id',
			null,
			'inner',
			$storeId
		);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$this->addColumn('id',
			[
				'header' => Mage::helper('vendor')->__('Id'),
				'width' => '50px',
				'index' => 'id',
			]
		);
		$this->addColumn('firstname',
			[
				'header' => Mage::helper('vendor')->__('First Name'),
				'width' => '50px',
				'index' => 'firstname',
			]
		);
		$this->addColumn('lastname',
			[
				'header' => Mage::helper('vendor')->__('Last Name'),
				'width' => '50px',
				'index' => 'lastname',
			]
		);
		$this->addColumn('email',
			[
				'header' => Mage::helper('vendor')->__('Email'),
				'width' => '50px',
				'index' => 'email',
			]
		);

		return parent::_prepareColumns();

	}

	public function getGridUrl() {
		return $this->getUrl('*/*/index', array('_current' => true));
	}

	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array(
			'store' => $this->getRequest()->getParam('store'),
			'id' => $row->getId())
		);
	}
}