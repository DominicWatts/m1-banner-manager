<?php

/**
 * Abstract model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Abstract extends Mage_Core_Model_Abstract {
    
    protected $_sliderPrefix    = null;
    protected $_bannerPrefix    = null;

    /**
     * Init Model default properties
     *
     */
    public function _construct() {

        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
        $this->_bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();
        parent::_construct();
        
    }
}