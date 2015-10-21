<?php

/**
 * Banner controller
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Adminhtml_Bannermanager_BannerController extends Xigen_Bannermanager_Controller_Adminhtml_Abstract {

    /**
     * Init actions
     *
     * @return Xigen_Bannermanager_Adminhtml_BannerController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('banner/manage')
            ->_addBreadcrumb(
                  Mage::helper('xigen_bannermanager')->__('Banner'),
                  Mage::helper('xigen_bannermanager')->__('Banner')
              )
            ->_addBreadcrumb(
                  Mage::helper('xigen_bannermanager')->__('Manage Banner'),
                  Mage::helper('xigen_bannermanager')->__('Manage Banner')
              )
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banner'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Banner
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Banner
     */
    public function editAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banner'));

        // 1. instance banner model
        /* @var $model Xigen_Bannermanager_Model_Item */
        $model = Mage::getModel('xigen_bannermanager/banner');

        // 2. if exists id, check it and load data
        $bannerId = $this->getRequest()->getParam('id');
        if ($bannerId) {
            $model->load($bannerId);

            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('xigen_bannermanager')->__('Banner does not exist.')
                );
                return $this->_redirect('*/*/');
            }
            // prepare title
            $this->_title($model->getTitle());
            $breadCrumb = Mage::helper('xigen_bannermanager')->__('Edit Item');
        } else {
            $this->_title(Mage::helper('xigen_bannermanager')->__('New Item'));
            $breadCrumb = Mage::helper('xigen_bannermanager')->__('New Item');
        }

        // Init breadcrumbs
        $this->_initAction()->_addBreadcrumb($breadCrumb, $breadCrumb);

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('xigen_bannermanager_banner', $model);

        // 5. render layout
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        $redirectPath   = '*/*';
        $redirectParams = array();

        // check if data sent
        $data = $this->getRequest()->getPost();
        if ($data) {
            $data = $this->_filterBannerData($data);
            // init model and set data
            /* @var $model Xigen_Bannermanager_Model_Item */
            $model = Mage::getModel('xigen_bannermanager/banner');

            // if banner exists, try to load it
            $bannerId = $this->getRequest()->getParam($this->_bannerPrefix . 'id');
            if ($bannerId) {
                $model->load($bannerId);
            }
            
            // save image data and remove from data array
            if (isset($data['image'])) {
                $imageData = $data['image'];
                unset($data['image']);
            } else {
                $imageData = array();
            }
            
            $model->addData($data);

            try {
                $hasError = false;
                /* @var $imageHelper Xigen_Bannermanager_Helper_Image */
                $imageHelper = Mage::helper('xigen_bannermanager/image');
                // remove image

                if (isset($imageData['delete']) && $model->getBannerImage()) {
                    $imageHelper->removeImage($model->getBannerImage());
                    $model->setBannerImage(null);
                }

                // upload new image
                $imageFile = $imageHelper->uploadImage('image');
                if ($imageFile) {
                    if ($model->getBannerImage()) {
                        $imageHelper->removeImage($model->getBannerImage());
                    }
                    $model->setBannerImage($imageFile);
                }
                                
                // save the data
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The banner has been saved.')
                );

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $redirectPath   = '*/*/edit';
                    $redirectParams = array('id' => $model->getId());
                }
                
            } catch (Mage_Core_Exception $e) {
                
                $hasError = true;
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $hasError = true;
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while saving the banner.')
                );
            }

            if ($hasError) {
                
                $this->_getSession()->setFormData($data);
                $redirectPath   = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam($this->_bannerPrefix . 'id'));
                
            }
        }

        $this->_redirect($redirectPath, $redirectParams);
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        $bannerId = $this->getRequest()->getParam('id');
        if ($bannerId) {
            try {
                
                // init model and delete
                /** @var $model Xigen_Bannermanager_Model_Item */
                $model = Mage::getModel('xigen_bannermanager/banner');
                $model->load($bannerId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a banner.'));
                }
                $model->delete();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The banner has been deleted.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while deleting the banner.')
                );
                
            }
        }

        // go to grid
        $this->_redirect('*/*/');
    }
    
    /**
     * Trash action
     */
    public function trashAction()
    {
        // check if we know what should be deleted
        $bannerId = $this->getRequest()->getParam('id');
        if ($bannerId) {
            try {
                
                // init model and trash
                /** @var $model Xigen_Bannermanager_Model_Comment */
                $model = Mage::getModel('xigen_bannermanager/banner');
                $model->load($bannerId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a banner.'));
                }
                $model->setBannerIsTrash(1);
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The banner has been put in the trash.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while moving the banner to the trash.')
                );
                
            }
        }

        // go to grid
        $this->_redirect('*/*/');
    }
    
    /**
     * Restore action
     */
    public function restoreAction()
    {
        // check if we know what should be deleted
        $bannerId = $this->getRequest()->getParam('id');
        if ($bannerId) {
            try {
                
                // init model and trash
                /** @var $model Xigen_Bannermanager_Model_Comment */
                $model = Mage::getModel('xigen_bannermanager/banner');
                $model->load($bannerId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a banner.'));
                }
                $model->setBannerIsTrash(0);
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The banner has been restored from trash.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while restoring the banner from the trash.')
                );
                
            }
        }

        // go to grid
        $this->_redirect('*/*/index', array('is_trash'=>'1'));
    }
    
    /**
     * mass delete item(s) action
     */
    public function massDeleteAction() {
        $bannerIds = $this->getRequest()->getParam($this->_bannerPrefix);
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getModel('xigen_bannermanager/banner')->load($bannerId);
                    $banner->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d banner(s) were successfully deleted', count($bannerIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        // go to grid
        $this->_redirect('*/*/index', array('is_trash'=>'1'));
    }
    
     /**
     * mass delete item(s) action
     */
    public function massTrashAction() {
        $bannerIds = $this->getRequest()->getParam($this->_bannerPrefix);
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getModel('xigen_bannermanager/banner')->load($bannerId);
                    $banner->setBannerIsTrash(1);
                    $banner->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d banner(s) were successfully moved to trash', count($bannerIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        // go to grid
        $this->_redirect('*/*/index');
    }
    
     /**
     * mass restore item(s) action
     */
    public function massRestoreAction() {
        $bannerIds = $this->getRequest()->getParam($this->_bannerPrefix);
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getModel('xigen_bannermanager/banner')->load($bannerId);
                    $banner->setBannerIsTrash(0);
                    $banner->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d banner(s) were successfully restored from trash', count($bannerIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        // go to grid
        $this->_redirect('*/*/index', array('is_trash'=>'1'));
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/banner/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/banner/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/banner');
                break;
        }
    }
    
    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterBannerData($data)
    {
        $data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    /**
     * Grid ajax action
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * Post ajax action
     */
    public function postAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('post.grid');
        $this->renderLayout();
    }
    
     /**
     * Post Grid ajax action
     */
    public function postgridAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('post.grid');
        $this->renderLayout();
    }

}