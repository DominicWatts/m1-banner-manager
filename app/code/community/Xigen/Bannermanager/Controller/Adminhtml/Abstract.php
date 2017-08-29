<?php

/**
 * Abstract controller
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Controller_Adminhtml_Abstract extends Mage_Adminhtml_Controller_Action
{
    protected $_bannerPrefix        = null;
    protected $_sliderPrefix        = null;
    protected $_trashFilter         = null;
    
    /**
     * Init controller default properties
     *
     */
    protected function _construct()
    {
        $this->_bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();
        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
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
                return Mage::getSingleton('admin/session')->isAllowed('slider/manage_slider/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('slider/manage_slider/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('slider/manage_slider');
                break;
        }
    }
}
