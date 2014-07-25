<?php

/**
 * Default block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Slider extends Xigen_Bannermanager_Block_Abstract {

        
    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED  = 'xigen_bannermanager/bannermanager/enabled';

    /**
     * Checks whether post can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null) {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }
    
    public function getBaseUrl() {
        /* @var $imageHelper Xigen_Bannermanager_Helper_Image */
        $imageHelper = Mage::helper('xigen_bannermanager/image');
        return $imageHelper->getBaseUrl();
    }

    public function getSliderData() {
                
        if(!$this->isEnabled()) {
            return false;
        }
        
        if (!$this->hasData('banner_data')) {

            $slider_id = $this->getSliderId();
            if ($slider_id) {
                $banner_data = Mage::getModel('xigen_bannermanager/slider')->load($slider_id);
            } else {
                $banner_data = $this->getSliderData();
            }
            
            $banners = Mage::getModel('xigen_bannermanager/banner')->getCollection()
                    ->addFieldToFilter($this->_bannerPrefix . 'slider_id', $banner_data->getSliderId())
                    ->addFieldToFilter($this->_bannerPrefix . 'is_active', 1)
                    ->addFieldToFilter($this->_bannerPrefix . 'is_trash', 0);
            
            $banners->getSelect()->order(
                array($banner_data->getSliderSort() == 'random' ? 'rand()' : 'banner_sort_order')
            );
            
            // $banners->printLogQuery(true);

            $result = array();
            $result['block'] = $banner_data;
            $result['banners'] = array();
            foreach ($banners as $banner) {
                $result['banners'][] = $banner->getData();
            }
            $this->setData('banner_data', $result);
        }
        return $this->getData('banner_data');
    }

}
