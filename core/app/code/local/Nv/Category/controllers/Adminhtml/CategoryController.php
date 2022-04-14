<?php

class Nv_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
     
    public function indexAction()
    {
        $this->_title($this->__('Category'))->_title($this->__('Manage Category'));
        $this->loadLayout();
        $this->_setActiveMenu('category/category');
        $this->renderLayout();

    }

    public function editAction() 
    {
        $this->loadLayout();
        $model = Mage::getModel('category/category');

        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('category')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
        } 
        Mage::register('category_data', $model);  

        $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category_edit')) //blocks
            ->_addLeft($this->getLayout()->createBlock('category/adminhtml_category_edit_tabs'));
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
            $model2  = Mage::getModel('category/category')->load($id);
            $model = Mage::getModel('category/category');             
            $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted.'));
            $this->_redirect('category/adminhtml_category/grid');   
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('category/adminhtml_category/index');
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
            $model = Mage::getModel('category/category')->load($id);
            $model->setData('parentId',$this->getRequest()->getPost('parentId'));
            $model->setData('name',$this->getRequest()->getPost ('name'));
            $model->setData('path',$this->getRequest()->getPost('path'));
            $model->setData('status',$this->getRequest()->getPost('status'));
            if($id){
                $model->setData('updatedAt', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            else{
                $model->setData('createdAt', Mage::getModel('core/date')->date('Y-m-d H:i:s'));
            }
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('category')->__('category saved successfully.'));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('category/adminhtml_category/index');
    }

    public function massDeleteAction() 
    {
        $categoryIds = $this->getRequest()->getParam('category');
        if(!is_array($categoryIds))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($categoryIds as $categoryId)
                {
                    $category = Mage::getModel('category/category')->load($categoryId);
                    $category->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($categoryIds)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('category/adminhtml_category/index');
    }

}

