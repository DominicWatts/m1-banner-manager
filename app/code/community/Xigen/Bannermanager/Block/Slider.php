<?php

/**
 * Slider block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Slider extends Xigen_Bannermanager_Block_Abstract {
   
    /**
     * Preparing global layout
     * @return Mage_Core_Block_Abstract
     */
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Get image base url
     * @return string
     */
    public function getBaseUrl() {
        /* @var $imageHelper Xigen_Bannermanager_Helper_Image */
        $imageHelper = Mage::helper('xigen_bannermanager/image');
        return $imageHelper->getBaseUrl();
    }

    /**
     *
     * Get slider data
     * @return mixed
     */
    public function getSliderData() {
                
        if(!$this->isEnabled()) {
            return false;
        }
        
        if (!$this->hasData('banner_data')) {

            if ($slider_id = $this->getSliderId()) {
                $banner_data = Mage::getModel('xigen_bannermanager/slider')->load($slider_id);
                if($banner_data->getStoreId() > 0) {
                    $store_ids = explode(',', $banner_data->getStoreId());
                    if (!in_array(Mage::app()->getStore()->getStoreId(), $store_ids)) {
                        return false;
                    }
                }
            } else {
                return false;
            }
            
            /**
             * Defined in XML
             * $this->getBlockPosition()
             * $this->getCatalogBlockPosition()
             * $this->getPopupPosition()
             * $this->getBlocknotePosition()
             */
            
            $banners = Mage::getModel('xigen_bannermanager/banner')->getCollection()
                ->addFieldToFilter($this->_bannerPrefix . 'slider_id', $slider_id)
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
    
    /**
     * Load template style block
     * @param type $style
     * @param type $result
     * @return mixed
     */
    public function sliderTemplate($style = false, $result = false) {
        
        if($style == false || $result == false) {
            return false;
        }
                        
        return $this->getLayout()
                ->createBlock('xigen_bannermanager/slider')
                ->setBlockData($result)
                ->setTemplate('xigen/bannermanager/' . $style . '.phtml')
                ->toHtml();
    }

 
    
    
}
