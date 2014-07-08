<?php

/**
 * Banner Manager Data helper
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Helper_Data extends Mage_Core_Helper_Data {

    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED = 'xigen_bannermanager/bannermanager/enabled';

    /**
     * Banner Item instance for lazy loading
     *
     * @var Xigen_Bannermanager_Model_Banner
     */
    protected $_bannerInstance;
    
    /**
     * Slider Item instance for lazy loading
     *
     * @var Xigen_Bannermanager_Model_Slider
     */
    protected $_sliderInstance;
    
    /**
     * Checks whether post can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null) {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
    
    /**
     * Return current banner item instance from the Registry
     *
     * @return Xigen_Bannermanager_Model_Banner
     */
    public function getBannerInstance() {
        if (!$this->_bannerInstance) {
            $this->_bannerInstance = Mage::registry('xigen_bannermanager_banner');

            if (!$this->_bannerInstance) {
                Mage::throwException($this->__('Banner item instance does not exist in Registry'));
            }
        }

        return $this->_bannerInstance;
    }    
    
    /**
     * Return current slider item instance from the Registry
     *
     * @return Xigen_Bannermanager_Model_Slider
     */
    public function getSliderInstance() {
        if (!$this->_sliderInstance) {
            $this->_sliderInstance = Mage::registry('xigen_bannermanager_slider');

            if (!$this->_sliderInstance) {
                Mage::throwException($this->__('Slider item instance does not exist in Registry'));
            }
        }

        return $this->_sliderInstance;
    }    


}
