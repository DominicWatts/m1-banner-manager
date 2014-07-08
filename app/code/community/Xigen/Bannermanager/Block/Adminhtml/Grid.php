<?php

/**
 * Reuseable code for admin grids
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    
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
        $this->_trashFilter  = $this->getRequest()->getParam('is_trash');
        parent::__construct();
        
    }
    
    /*
     * Add to collection
     *
     * return Xigen_Bannermanager_Block_Adminhtml_Grid
     */
    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    
    /**
     * Return row URL for js event handlers
     * @param type $row
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    } 
    
    /**
     * Grid Slider lookup
     * @param string $slider_id
     * @return Xigen_Bannermanager_Model_Slider
     */
    public function _loadSlider($slider_id) {
        
        $_slider = Mage::getModel('xigen_bannermanager/slider')->load($slider_id);
        if($_slider) {
            return $_slider->getSliderTitle();
        } 
        return false;
    }
    
    /**
     * Yes/No
     * @param string $value
     * @return string
     */
    public function _loadYesNo($value) {
        return Mage::helper('xigen_bannermanager/admin')->getYesNoValue($value);
    }
    

}