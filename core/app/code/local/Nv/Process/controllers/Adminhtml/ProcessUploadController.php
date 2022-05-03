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
        try {
            $Id = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process');
            if ($process->load($Id)) {
                $model = Mage::getModel($process->getRequestModel());
                $filename = $model->setProcess($process)->verify();
            }
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
        $this->loadLayout();
        $id = $this->getRequest()->getParam('id');
        $process = Mage::getModel('process/process')->load($id);
        $entry = Mage::getModel('process/process_entry');
        $select = $entry->getCollection()
                        ->getSelect()
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->columns('data')
                        ->where('process_id = '.$id);
        $entryRows = $entry->getResource()->getReadConnection()->fetchAll($select);
        $totalCount = count($entryRows);
        $perRequestCount = $process->getPerRequestCount();
        $totalRequest = $totalCount/$perRequestCount;
        $currentRequest = 1;
        Mage::getSingleton('core/session')->setVariables(['processId' => $id, 'totalCount' => $totalCount, 'perRequestCount' => $perRequestCount, 'totalRequest' => $totalRequest, 'currentRequest' => $currentRequest]);
        $this->renderLayout();
    }

    public function executeEntryAction()
    {
        try {
            $session = Mage::getSingleton('core/session')->setVariables();
            $processId = $session['processId'];
            $totalCount = $session['totalCount'];
            $perRequestCount = $session['perRequestCount'];
            $totalRequest = $session['totalRequest'];
            $currentRequest = $session['currentRequest'];

            $process = Mage::getModel('process/process')->load($processId);
            $entry = Mage::getModel('process/process_entry');
            $select = $entry->getCollection()
                            ->getSelect()
                            ->reset(Zend_Db_Select::COLUMNS)
                            ->columns('data')
                            ->limit($perRequestCount, $currentRequest);
            $entryRows = $entry->getResource()->getReadConnection()->fetchAll($select);

            foreach ($entryRows as $key => $row) {
                $entryRows[$key] = json_decode($row['data']);
            }
            foreach ($entryRows as $key => $row) {
               $model = Mage::getModel($process->getRequestModel());
                $model->setData('name', $row->name);
               $model->setData('path', $row->path);
               $model->save();
            }

        }
        catch (Exception $e) {
            
        }
    }
}

?>