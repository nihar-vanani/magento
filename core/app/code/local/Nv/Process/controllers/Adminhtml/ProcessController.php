<?php 
class Nv_Process_Adminhtml_ProcessController extends Mage_Adminhtml_Controller_Action
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

	public function uploadAction()
	{
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('process/adminhtml_process_upload'));
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$this->loadLayout();
        $model = Mage::getModel('process/process');
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

        $this->_addLeft($this->getLayout()->createBlock('process/adminhtml_process_edit_tabs'));
        $this->renderLayout();
	}

	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			$id = $this->getRequest()->getParam('id');
			$postData = $this->getRequest()->getPost();
			$model = Mage::getModel('process/process');
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
				$model = Mage::getModel('process/process');

				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				$this->_redirect('*/*/');
			} catch (Exception $e) {
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() 
    {
        $process_ids = $this->getRequest()->getParam('process');
        if(!is_array($process_ids))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($process_ids as $process_id)
                {
                    $process = Mage::getModel('process/process')->load($process_id);
                    $process->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($process_ids)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteEntriesAction() 
    {
        $process_ids = $this->getRequest()->getParam('process');
        if(!is_array($process_ids))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($process_ids as $process_id)
                {
                    $entry = Mage::getModel('process/process_entry');
        			$select = $entry->getCollection()
                        ->getSelect()
                        ->where('process_id = '.$process_id);
        			$entries = $entry->getResource()->getReadConnection()->fetchAll($select);
        			foreach ($entries as $key => $row) {
        				$entry->setData($row);
        				$entry->delete();
        			}
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($process_ids)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteColumnsAction() 
    {
    	echo "<pre>";
        $process_ids = $this->getRequest()->getParam('process');
        if(!is_array($process_ids))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($process_ids as $process_id)
                {
                    $column = Mage::getModel('process/process_column');
        			$select = $column->getCollection()
                        ->getSelect()
                        ->where('process_id = '.$process_id);
        			$columns = $column->getResource()->getReadConnection()->fetchAll($select);
        			foreach ($columns as $key => $row) {
                    	$column->setData($row);
        				$column->delete();
        			}
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($process_ids)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

}