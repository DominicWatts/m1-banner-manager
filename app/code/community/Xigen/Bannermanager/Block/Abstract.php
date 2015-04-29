<?php

/**
 * Abstract model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Abstract extends Mage_Core_Block_Template {
    
    protected $_sliderPrefix    = null;
    protected $_bannerPrefix    = null;

    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED  = 'xigen_bannermanager/bannermanager/enabled';
    
    /**
     * Init Model default properties
     *
     */
    public function _construct() {

        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
        $this->_bannerPrefix = Mage::helper('xigen_bannermanager/database')->getBannerPrefix();
        parent::_construct();
        
    }
    
    /**
     * Checks whether post can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null) {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
}