<?php
class Xigen_Bannermanager_Helper_Database extends Mage_Core_Helper_Data {
        
    /**
     * Class constants
     */
    const SLIDER = 'slider_';
    const BANNER = 'banner_';
    
    /**
     * Slider table prefix
     * @return string
     */
    public function getSliderPrefix() {
        return self::SLIDER;
    }
    /**
     * Banner table prefix
     * @return string
     */
    public function getBannerPrefix() {
        return self::BANNER;
    }
    
   
}