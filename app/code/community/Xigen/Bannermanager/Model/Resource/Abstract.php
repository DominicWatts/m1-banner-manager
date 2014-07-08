<?php

/**
 * Abstract resource model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract {
    
    protected $_sliderPrefix    = null;
    protected $_bannerPrefix    = null;
     /**
     * Init Model default properties
     *
     */
    protected function _construct() {

        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
        $this->_bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();
   
    }
}