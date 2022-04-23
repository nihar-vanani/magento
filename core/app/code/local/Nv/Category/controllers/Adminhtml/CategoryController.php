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
                throw new Exception("Invalid request.", 1);
            }
            $path = '';
            $postData = $this->getRequest()->getPost();
            unset($postData['form_key']);
            $categoryRow = Mage::getModel('category/category');
            $adapter = $categoryRow->getResource()->getReadConnection();
            $id = $this->getRequest()->getParam('id');
            if($id)
            {
                $categoryPath = $adapter->fetchOne("SELECT `path` FROM `category` WHERE `category_id` = {$id}");
                $categoryRow->setData($postData);
                if ($categoryRow->parent_id == 0) 
                {
                    $categoryRow->parent_id = 0;
                }
                $categoryRow->category_id = $id;
                $categoryRow->updated_at = date('Y-m-d H:i:s');
                $category = $categoryRow->save();
                $this->saveCategory($category->category_id);
                $query= $categoryRow->getCollection()->getSelect()->where("`path` LIKE '".$categoryPath.'/%'."'")->order('path');
                $subcategories = $adapter->fetchAll($query);
                foreach ($subcategories as $row) 
                {
                    $query= $categoryRow->getCollection()->getSelect()->where("`category_id` = {$row['parent_id']}")->order('path');
                    $parent = $adapter->fetchRow($query);
                    $newPath = $parent['path'].'/'.$row['category_id'];
                    $row['path'] = $newPath;
                    $row['updated_at'] = date('Y-m-d H:i:s');
                    
                    Mage::getModel('category/category')->setData($row)->save();
                }
            }
            else
            {
                $categoryRow->setData($postData);
                $categoryRow->created_at = date('Y-m-d H:i:s');
                $category = $categoryRow->save();
                if(!$category)
                {
                    throw new Exception("System is unable to insert.", 1);          
                }
                $this->saveCategory($category->getId());
            }
            $this->_redirect('*/*/');
        } 
        catch (Exception $e) 
        {
            $this->_redirect('*/*/');
        }
    }

    protected function saveCategory($id)
    {
        $categoryRow = Mage::getModel('category/category');
        $category = $categoryRow->load($id);
        $category_id = $category->getId();
        if ($category->getData('parent_id') == 0) 
        {
            $path = $category->getId();
        }
        else
        {
            $result=$categoryRow->load($category->parent_id);
            $path = $result->path.'/'.$category_id;
        }
        $category=$categoryRow->load($category_id);
        $category->path = $path;
        
        $update = $category->save();
        if(!$update)
        {
            throw new Exception("System is unable to update.", 1);
        }
        
    }

    public function massDeleteAction() 
    {
        $category_ids = $this->getRequest()->getParam('category');
        if(!is_array($category_ids))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($category_ids as $category_id)
                {
                    $category = Mage::getModel('category/category')->load($category_id);
                    $category->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($category_ids)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('category/adminhtml_category/index');
    }

}

