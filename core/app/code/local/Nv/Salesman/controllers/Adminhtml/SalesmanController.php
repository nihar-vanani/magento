<?php

class Nv_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
     
    public function indexAction()
    {
        $this->_title($this->__('Salesman'))->_title($this->__('Manage Salesman'));
        $this->loadLayout();
        $this->_setActiveMenu('salesman/salesman');
        $this->renderLayout();

    }

    public function editAction() 
    {
        $this->loadLayout();
        $model = Mage::getModel('salesman/salesman');

        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
        } 
        Mage::register('salesman_data', $model);  

        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit')) //blocks
            ->_addLeft($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function deleteAction()
    {
        try
        {
            if(!$this->getRequest()->getParam('id') > 0)
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Invalid request.'));
            } 
            
            $id     = $this->getRequest()->getParam('id');
            $model2  = Mage::getModel('salesman/salesman')->load($id);
            $model = Mage::getModel('salesman/salesman');             
            $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted.'));
            $this->_redirect('salesman/adminhtml_salesman/grid');   
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('salesman/adminhtml_salesman/index');
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
            $model = Mage::getModel('salesman/salesman')->load($id);
            $model->setData('firstName',$this->getRequest()->getPost('firstName'));
            $model->setData('lastName',$this->getRequest()->getPost('lastName'));
            $model->setData('email',$this->getRequest()->getPost('email'));
            $model->setData('mobile',$this->getRequest()->getPost('mobile'));
            $model->setData('percentage',$this->getRequest()->getPost('percentage'));
            $model->setData('status',$this->getRequest()->getPost('status'));
            if($id){
                $model->setData('updatedAt', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            else{
                $model->setData('createdAt', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('salesman saved successfully.'));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('salesman/adminhtml_salesman/index');
    }

    public function massDeleteAction() 
    {
        $salesmanIds = $this->getRequest()->getParam('salesman');
        if(!is_array($salesmanIds))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($salesmanIds as $salesmanId)
                {
                    $salesman = Mage::getModel('salesman/salesman')->load($salesmanId);
                    $salesman->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($salesmanIds)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('salesman/adminhtml_salesman/index');
    }

}

