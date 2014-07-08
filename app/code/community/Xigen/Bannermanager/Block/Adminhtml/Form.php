<?php

/**
 * Reuseable code for admin grids
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Form extends Mage_Adminhtml_Block_Widget_Form {
    
    protected $_bannerPrefix        = null;
    protected $_sliderPrefix        = null;
    protected $_trashFilter         = null;    
    
     /**
     * Init Grid default properties
     *
     */
    public function __construct() {

        $this->_bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();
        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
        $this->_trashFilter         = $this->getRequest()->getParam('is_trash');
        parent::__construct();
        
    }
}