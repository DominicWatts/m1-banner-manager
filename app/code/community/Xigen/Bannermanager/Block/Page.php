<?php

/**
 * Slider block
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Page extends Xigen_Bannermanager_Block_Abstract {
    
    /*
     * Render block logic - this block logic is called via the design XML and config values for the 
     * particular slideshow in relation to the page the customer is currently viewing
     */
    public function _toHtml() { 
        
        if(!$this->isEnabled()) {
            return;
        }
        
        $cmsPageUrlKey = $this->getCmsPageKey();
        
         // Defined in XML
         // $this->getBlockPosition()
         // $this->getCatalogBlockPosition()
         // $this->getPopupPosition()
         // $this->getBlocknotePosition()
         
        $collection = null;
        $banners    = array(); 
        $collection = Mage::getModel('xigen_bannermanager/slider')->getCollection()
            ->addFieldToFilter($this->_sliderPrefix . 'is_active', 1)
            ->addFieldToFilter($this->_sliderPrefix . 'is_trash', 0)
            ->addFieldToFilter($this->_sliderPrefix . 'position', 
                array('in' => array(
                    $this->getBlockPosition(), $this->getCatalogBlockPosition(), $this->getPopupPosition(), $this->getBlocknotePosition())
                )
            );
                
        foreach ($collection as $item) {
            
            $show = false;
            
            // CMS Page check
            if($item->getSliderPage() && $item->getSliderPage() == $cmsPageUrlKey) {
                $show = true;
            } elseif(!$item->getSliderPage()) {
                $show = true;
            }
            
            // Store Check
            if($item->getStoreId() > 0) {
                $store_ids = explode(',', $item->getStoreId());
                if (!in_array(Mage::app()->getStore()->getStoreId(), $store_ids)) {
                    $show = false;
                } 
            }
            
            // Category Check
            if($item->getCategoryId()) {
                if($category = $this->getCurrentCategory()) {
                    $show = false;
                    $pathIds = $category->getPathIds();
                    foreach($pathIds as $pathId) {
                        $category_ids = explode(',', $item->getCategoryId());
                        if (in_array($pathId, $category_ids)) {
                            $show = true;
                        } 
                    }
                }
            }
            
            if($show) {
                echo $this->getLayout()->createBlock('xigen_bannermanager/slider')
                    ->setTemplate('xigen/bannermanager/slider.phtml')
                    ->setSliderId($item->getSliderId())
                    ->toHtml(); 
            } 
            
        }
       
    }
    
    /*
     * Get CMS Page Key
     * @return mixed
     */
    public function getCmsPageKey() {
        return Mage::getSingleton('cms/page')->getIdentifier();
    }
    
    /*
     * Get current category
     */
    public function getCurrentCategory() {
        return Mage::registry('current_category');
    }
}