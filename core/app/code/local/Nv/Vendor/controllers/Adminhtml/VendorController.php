<?php

class Nv_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
    const ENTITY_TYPE_ID = 11;

    protected function _initEdit()
    {
        $this->_title($this->__('Vendors'))->_title($this->__('Vendor Edit'));

        Mage::register('current_edit', Mage::getModel('vendor/vendor'));
        $vendorId = $this->getRequest()->getParam('id');
        if (!is_null($vendorId)) {
            Mage::registry('current_edit')->load($vendorId);
        }

    }

    public function indexAction()
    {
        
        $this->_title($this->__('Vendor'))->_title($this->__('Manage Vendor'));
        $this->loadLayout();
        $this->_setActiveMenu('vendor/vendor');
        $this->renderLayout();

    }

    public function newsAction()
    {
        $this->_initEdit();
        $this->loadLayout();
        $this->_setActiveMenu('vendor/vendor');
        $this->_addBreadcrumb(Mage::helper('vendor')->__('Vendors'), Mage::helper('vendor')->__('Vendors'));
        $this->_addBreadcrumb(Mage::helper('vendor')->__('Vendor Edit'), Mage::helper('vendor')->__('Vendor Edit'), $this->getUrl('*/vendor_edit'));

        $currentEdit = Mage::registry('current_edit');

        if (!is_null($currentEdit->getId())) {
            $this->_addBreadcrumb(Mage::helper('vendor')->__('Edit Group'), Mage::helper('vendor')->__('Edit Vendor'));
        } else {
            $this->_addBreadcrumb(Mage::helper('vendor')->__('New Group'), Mage::helper('vendor')->__('New Vendor Groups'));
        }

        $this->_title($currentEdit->getId() ? $currentEdit->getCode() : $this->__('New Group'));

        $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit', 'vendorEdit')->setEditMode((bool)Mage::registry('current_edit')->getId()));

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
            $postData = $this->getRequest()->getPost();
            $model = Mage::getModel('vendor/vendor');
            $date = date('Y-m-d H:i:s');
            $id = $this->getRequest()->getParam('id');
            unset($postData['form_key']);
            if ($id) 
            {
                $postData['updated_date'] = $date;
                foreach($postData as $key => $value)
                {
                    $attributeRow = $model->getResource()->getReadConnection()->fetchRow("SELECT * FROM `eav_attribute` WHERE `attribute_code` = '$key' AND `entity_type_id` = 11");
                    $attributeId = $attributeRow['attribute_id'];
                    $backendType = $attributeRow['backend_type'];
                    $entityRow = $model->getResource()->getReadConnection()->fetchRow("SELECT * FROM `vendor_entity_{$backendType}` WHERE `entity_id` = {$id} AND `attribute_id` = {$attributeId}");
                    $valueId = $entityRow['value_id'];
                    $result = $model->getResource()->getReadConnection()->fetchAll("UPDATE `vendor_entity_{$backendType}` SET value = '{$value}' WHERE value_id = $valueId AND attribute_id = $attributeId");
                    $model->save();
                }
            }
            else
            {
                $model->setData($postData);
                $model->setcreatedDate($date);
                $model->setupdatedDate($date);
                $model->save();
            }
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

