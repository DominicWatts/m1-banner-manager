<?php

/**
 * Slider controller
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Adminhtml_Bannermanager_SliderController extends Xigen_Bannermanager_Controller_Adminhtml_Abstract {

    /**
     * Init actions
     *
     * @return Xigen_Bannermanager_Adminhtml_SliderController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('slider/manage')
            ->_addBreadcrumb(
                  Mage::helper('xigen_bannermanager')->__('Slider'),
                  Mage::helper('xigen_bannermanager')->__('Slider')
              )
            ->_addBreadcrumb(
                  Mage::helper('xigen_bannermanager')->__('Manage Slider'),
                  Mage::helper('xigen_bannermanager')->__('Manage Slider')
              )
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Slider'))
             ->_title($this->__('Manage Slider'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Slider
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Slider
     */
    public function editAction()
    {
        $this->_title($this->__('Slider'))
             ->_title($this->__('Manage Slider'));

        // 1. instance slider model
        /* @var $model Xigen_Bannermanager_Model_Item */
        $model = Mage::getModel('xigen_bannermanager/slider');

        // 2. if exists id, check it and load data
        $sliderId = $this->getRequest()->getParam('id');
        if ($sliderId) {
            $model->load($sliderId);

            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('xigen_bannermanager')->__('Slider does not exist.')
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
        Mage::register('xigen_bannermanager_slider', $model);

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
            
            if (isset($data['stores'])) {
                if (in_array('0', $data['stores'])) {
                    $data['store_id'] = '0';
                } else {
                    $data['store_id'] = join(",", $data['stores']);
                }
                unset($data['stores']);
            }
            
            $data = $this->_filterSliderData($data);
            // init model and set data
            /* @var $model Xigen_Bannermanager_Model_Item */
            $model = Mage::getModel('xigen_bannermanager/slider');

            // if slider exists, try to load it
            $sliderId = $this->getRequest()->getParam($this->_sliderPrefix . 'id');
            if ($sliderId) {
                $model->load($sliderId);
            }
                        
            $model->addData($data);

            try {
                $hasError = false;
                                               
                // save the data
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The slider has been saved.')
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
                    Mage::helper('xigen_bannermanager')->__('An error occurred while saving the slider.')
                );
            }

            if ($hasError) {
                
                $this->_getSession()->setFormData($data);
                $redirectPath   = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
                
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
        $sliderId = $this->getRequest()->getParam('id');
        if ($sliderId) {
            try {
                
                // init model and delete
                /** @var $model Xigen_Bannermanager_Model_Item */
                $model = Mage::getModel('xigen_bannermanager/slider');
                $model->load($sliderId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a slider.'));
                }
                $model->delete();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The slider has been deleted.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while deleting the slider.')
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
        $sliderId = $this->getRequest()->getParam('id');
        if ($sliderId) {
            try {
                
                // init model and trash
                /** @var $model Xigen_Bannermanager_Model_Comment */
                $model = Mage::getModel('xigen_bannermanager/slider');
                $model->load($sliderId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a slider.'));
                }
                $model->setSliderIsTrash(1);
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The slider has been put in the trash.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while moving the slider to the trash.')
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
        $sliderId = $this->getRequest()->getParam('id');
        if ($sliderId) {
            try {
                
                // init model and trash
                /** @var $model Xigen_Bannermanager_Model_Comment */
                $model = Mage::getModel('xigen_bannermanager/slider');
                $model->load($sliderId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('xigen_bannermanager')->__('Unable to find a slider.'));
                }
                $model->setSliderIsTrash(0);
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('xigen_bannermanager')->__('The slider has been restored from trash.')
                );
                
            } catch (Mage_Core_Exception $e) {
                
                $this->_getSession()->addError($e->getMessage());
                
            } catch (Exception $e) {
                
                $this->_getSession()->addException($e,
                    Mage::helper('xigen_bannermanager')->__('An error occurred while restoring the slider from the trash.')
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
        $sliderIds = $this->getRequest()->getParam($this->_sliderPrefix);
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('xigen_bannermanager/slider')->load($sliderId);
                    $slider->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d slider(s) were successfully deleted', count($sliderIds)));
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
        $sliderIds = $this->getRequest()->getParam($this->_sliderPrefix);
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('xigen_bannermanager/slider')->load($sliderId);
                    $slider->setSliderIsTrash(1);
                    $slider->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d slider(s) were successfully moved to trash', count($sliderIds)));
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
        $sliderIds = $this->getRequest()->getParam($this->_sliderPrefix);
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('xigen_bannermanager/slider')->load($sliderId);
                    $slider->setSliderIsTrash(0);
                    $slider->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d slider(s) were successfully restored from trash', count($sliderIds)));
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
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/slider/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/slider/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('cms/bannermanager/slider');
                break;
        }
    }
    
    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterSliderData($data)
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
    public function bannerAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('banner.grid');
        $this->renderLayout();
    }
    
     /**
     * Post Grid ajax action
     */
    public function bannergridAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('banner.grid');
        $this->renderLayout();
    }
    
    /**
     * Used in categories selector
     */
    public function chooserMainCategoriesAction() {
        
        $request = $this->getRequest();
        $ids = $request->getParam('selected', array());

        if (is_array($ids)) {
            foreach ($ids as $key => &$id) {
                $id = (int) $id;
                if ($id <= 0) {
                    unset($ids[$key]);
                }
            }
            $ids = array_unique($ids);
        } else {
            $ids = array();
        }
        
        $block = $this->getLayout()
            ->createBlock(
                'xigen_bannermanager/adminhtml_slider_edit_tab_categories', 
                'content_category', 
                array(
                    'js_form_object' => $request->getParam('form')
                )
            )
            ->setCategoryIds($ids);
       
        if ($block) {
            $this->getResponse()->setBody($block->toHtml());
        }
        
    }

    /**
     * Used in categories selector
     * @return mixed
     */
    public function categoriesJsonAction() {
        
        if ($categoryId = (int) $this->getRequest()->getPost('id')) {
            $this->getRequest()->setParam('id', $categoryId);

            if (!$category = $this->_initCategory()) {
                return;
            }
            $this->getResponse()->setBody(
                $this->getLayout()
                    ->createBlock('adminhtml/catalog_category_tree')
                    ->getTreeJson($category)
            );
        }
    }
    
    protected function _initCategory() {
        $categoryId = (int) $this->getRequest()->getParam('id', false);
        $storeId = (int) $this->getRequest()->getParam('store');

        $category = Mage::getModel('catalog/category');
        $category->setStoreId($storeId);

        if ($categoryId) {
            $category->load($categoryId);
            if ($storeId) {
                $rootId = Mage::app()->getStore($storeId)->getRootCategoryId();
                if (!in_array($rootId, $category->getPathIds())) {
                    $this->_redirect('*/*/', array('_current' => true, 'id' => null));
                    return false;
                }
            }
        }

        Mage::register('category', $category);
        Mage::register('current_category', $category);

        return $category;
    }

}