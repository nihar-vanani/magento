<?php
class Nv_Process_Adminhtml_ProcessUploadController extends Mage_Adminhtml_Controller_Action{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('process/process');
        $this->renderLayout();
    }

    public function uploadfileAction()
    {
        $processId = $this->getRequest()->getParam('id');
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));

		$process = Mage::getModel('process/process')
			->setStoreId($this->getRequest()->getParam('store', 0))
			->load($processId);

		Mage::register('current_process_media', $process);

		if (!$processId) {
			$this->_getSession()->addError(Mage::helper('process')->__('This process no longer exists'));
			$this->_redirect('*/*/');
			return;
		}
		$this->loadLayout();
		$this->renderLayout();
    }

    public function uploadAction()
    {
        $Id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('process/process');
        if($model->load($Id)){
            $fileName = $model->uploadFile($Id);
        }
        $this->_redirect('process/adminhtml_process/index');
    }

    public function verifyAction()
    {
        $Id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('process/process')->load($Id);
        $model->verify();
        $this->_redirect('process/adminhtml_process/index');
    }

    public function exportAction()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('process/process')->load($id);
            $csv = $model->downloadSample();
            $this->_prepareDownloadResponse($model->getFileName(), $csv);
            $this->_getSession()->addSuccess($this->__("File Downloaded."));
            $this->_redirect('process/adminhtml_process/index');
        }
        catch (Exception $e) {
            $this->_getSession()->addError($this->__($e->getMessage()));
            $this->_redirect('process/adminhtml_process/index');
        }
    }


}

?>