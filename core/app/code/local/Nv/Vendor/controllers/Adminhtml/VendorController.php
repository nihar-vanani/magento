<?php

class Nv_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Vendor'))->_title($this->__('Manage Vendor'));
        $this->loadLayout();
        $this->_setActiveMenu('vendor/vendor');
        $this->renderLayout();
    }

    public function editAction() 
    {

        $this->loadLayout();
        $model = Mage::getModel('vendor/vendor');

        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
           /* $data = Mage::getSingleton('adminhtml/session')->getFormData(true);                     
            if (!empty($data)) 
            {
                $model->setData($data); 
            }*/
        } 
        Mage::register('vendor_data', $model);  

        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit')) //blocks
            ->_addLeft($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tabs'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) 
        {

            $id     = $this->getRequest()->getParam('id');
            $model2  = Mage::getModel('vendor/vendor')->load($id);
            $model = Mage::getModel('vendor/vendor');             
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete(); //delete operation

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted'));
                $this->_redirect('vendor/adminhtml_vendor/grid');   

        }
        $this->_redirect('vendor/adminhtml_vendor/index');
    }   

    public function saveAction() 
    {   
        try
        {
            if (!$this->getRequest()->getPost())
            {   
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Invalid request.'));   
            }
                
            $id= ($this->getRequest()->getParam('id'));
            $model = Mage::getModel('vendor/vendor')->load($id);
            $model->setData('entity_id',$id);

            $model->setData('first_name',$this->getRequest()->getPost('first_name'));
            $model->setData('email',$this->getRequest()->getPost('email'));
            $model->setData('mobile',$this->getRequest()->getPost('mobile'));
            $model->setData('last_name',$this->getRequest()->getPost('last_name'));
            $model->setData('status',$this->getRequest()->getPost('status'));
            if($id){
                $model->setData('updated_date', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            else{
                $model->setData('created_date', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Vendor saved successfully.'));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('vendor/adminhtml_vendor/index');
    }

    public function massDeleteAction() 
    {
            $sampleIds = $this->getRequest()->getParam('vendor');
             if(!is_array($sampleIds))
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
            } 
            else 
            {
                try
                {
                    foreach ($sampleIds as $sampleId)
                    {
                        $sample = Mage::getModel('vendor/vendor')->load($sampleId);
                        $sample->delete();

                    }
                    Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($sampleIds)));
                } 
                catch (Exception $e)
                {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
                $this->_redirect('vendor/adminhtml_vendor/index');
    }

}

