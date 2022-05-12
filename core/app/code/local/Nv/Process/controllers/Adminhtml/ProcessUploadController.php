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
        $id = $this->getRequest()->getParam('id');
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));

		$process = Mage::getModel('process/process')
			->setStoreId($this->getRequest()->getParam('store', 0))
			->load($id);

		Mage::register('current_process_media', $process);

		if (!$id) {
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
        try {
            $Id = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process');
            if (!$process->load($Id)) {
                throw new Exception("No process found.", 1);
            }
            $model = Mage::getModel($process->getRequestModel());
            $model->setProcess($process)->verify();
            $this->_getSession()->addSuccess(Mage::helper('process')->__("File Verified successfully."));
        }
        catch (Exception $e) {
            $this->_getSession()->addError(Mage::helper('process')->__($e->getMessage()));
        }
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

    public function executeAction()
    {
        try {
            $this->loadLayout();
            $id = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process')->load($id);
            if (!$process) {
                throw new Exception("No process found.", 1);
            }
            $this->_prepareProcessEntryVariables($process);
            $this->renderLayout();
        }
        catch (Exception $e)
        {
            $this->_getSession()->addError($this->__($e->getMessage()));
            $this->_redirect('process/adminhtml_process/index');
        }
    }

    protected function _prepareProcessEntryVariables($process)
    {
        $sessionVariables = [
            'processId' => $process->getId(),
            'totalCount' => 0,
            'perRequestCount' => 0,
            'totalRequest' => 0,
            'currentRequest' => 0
        ];

        $entry = Mage::getModel('process/process_entry');
        $select = $entry->getCollection()
                        ->getSelect()
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->columns('count(entry_id)')
                        ->where('process_id = '.$process->getId())
                        ->where('start_time IS NULL');
        $entryCount = $entry->getResource()->getReadConnection()->fetchOne($select);

        if (!$entryCount) {
            Mage::getSingleton('core/session')->unsetProcessEntryVariables();
            throw new Exception("All records processed, No record available to process.", 1);
        }

        $sessionVariables['totalCount'] = $entryCount;
        $sessionVariables['perRequestCount'] = $process->getPerRequestCount();
        $sessionVariables['totalRequest'] = ceil($sessionVariables['totalCount']/$sessionVariables['perRequestCount']);
        $sessionVariables['currentRequest'] = 1;
        Mage::getSingleton('core/session')->setProcessEntryVariables($sessionVariables);
    }

    public function processEntryAction()
    {
        try {
            $sessionVariables = Mage::getSingleton('core/session')->getProcessEntryVariables($sessionVariables);
            if ($sessionVariables['currentRequest'] > $sessionVariables['totalRequest'])
            {
               throw new Exception("No Request Available");
            }
            $processId = $sessionVariables['processId'];
            $process = Mage::getModel('process/process')->load($processId);
            if (!$process) {
                throw new Exception("No Process Found.");
            }
            $requestModel = Mage::getModel($process->getRequestModel());
            $requestModel->setProcess($process)->execute();
            sleep(1);
            $reload = false;
            if ($sessionVariables['currentRequest'] == $sessionVariables['totalRequest']){
                $reload = true;
            }

            $sessionVariables['currentRequest'] += 1;
            Mage::getSingleton('core/session')->setProcessEntryVariables($sessionVariables);

            $response = [
                'status' => 'success',
                'reload' => $reload,
                'sessionVariables' => $sessionVariables,
                'message' => "Processing : " . ($sessionVariables['currentRequest'] - 1)*($sessionVariables['perRequestCount']). "|" .($sessionVariables['totalCount']),
            ];
           $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
        catch (Exception $e) {
            
        }
    }
}

?>