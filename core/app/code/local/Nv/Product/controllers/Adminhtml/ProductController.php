<?php

class Nv_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
     
    public function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('product/product');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->loadLayout();
        $model = Mage::getModel('product/product');
        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
        } 
        Mage::register('product_data', $model);  

        $this->_addLeft($this->getLayout()->createBlock('product/adminhtml_product_edit_tabs'));
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
            $model2  = Mage::getModel('product/product')->load($id);
            $model = Mage::getModel('product/product');             
            $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('successfully deleted.'));
            $this->_redirect('product/adminhtml_product/grid');   
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('product/adminhtml_product/index');
    }   

    public function saveAction() 
    {   
        try
        {
            if ( $this->getRequest()->getPost() )
            {
                $id = $this->getRequest()->getParam('id');
                $postData = $this->getRequest()->getPost();
                $model = Mage::getModel('product/product');
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
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('product saved successfully.'));
            Mage::dispatchEvent('product_save_etc', array('product' => $model));
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('product/adminhtml_product/index');
    }

    public function massDeleteAction() 
    {
        $productIds = $this->getRequest()->getParam('product');
        if(!is_array($productIds))
        {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select items.'));
        } 
        else 
        {
            try
            {
                foreach ($productIds as $productId)
                {
                    $product = Mage::getModel('product/product')->load($productId);
                    $product->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($productIds)));
            } 
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('product/adminhtml_product/index');
    }

}

