<?php

/**
 * Slider block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Page extends Xigen_Bannermanager_Block_Abstract {
    
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
            if($item->getSliderPage() && $item->getSliderPage() == $cmsPageUrlKey) {
                $show = true;
            } elseif(!$item->getSliderPage()) {
                $show = true;
            }
            
            if($item->getStoreId() > 0) {
                $store_ids = explode(',', $item->getStoreId());
                if (!in_array(Mage::app()->getStore()->getStoreId(), $store_ids)) {
                    $show = false;
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
}