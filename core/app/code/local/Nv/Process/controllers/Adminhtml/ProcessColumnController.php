<?php 
class Nv_Process_Adminhtml_ProcessColumnController extends Mage_Adminhtml_Controller_Action
{
	public function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('process/process');
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction();
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$this->loadLayout();
        $model = Mage::getModel('process/process_column');
        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('process')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
        } 
        Mage::register('process_data', $model);  

        $this->_addLeft($this->getLayout()->createBlock('process/adminhtml_process_column_edit_tabs'));
        $this->renderLayout();
	}

	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			$id = $this->getRequest()->getParam('id');
			$postData = $this->getRequest()->getPost();
			$model = Mage::getModel('process/process_column');
			$date = date('Y-m-d H:i:s');
			if ($id) {
				$model->setData($postData)->setId($this->getRequest()->getParam('id'))->setupdatedDate($date);
			}else{
				$model->setData($postData);
				$model->setcreatedDate($date);
			}
			$model->save();
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$salesmanModel = Mage::getModel('process/process_column');

				$salesmanModel->setId($this->getRequest()->getParam('id'))
				->delete();

				$this->_redirect('*/*/');
			} catch (Exception $e) {
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

}