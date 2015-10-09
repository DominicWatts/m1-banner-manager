<?php

/**
 * Banner Manager Admin helper
 *
 * @slider Xigen
 */
class Xigen_Bannermanager_Helper_Admin extends Mage_Core_Helper_Abstract {

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    public function isActionAllowed($action) {
        return Mage::getSingleton('admin/session')->isAllowed('banner/manage/' . $action);
    }

    /**
     * Yes/No Grid array
     * 
     * @return array
     */
    public function getYesNo() {
        return array(
            '0' => Mage::helper('xigen_bannermanager')->__('No'),
            '1' => Mage::helper('xigen_bannermanager')->__('Yes'),
        );
    }
    
    /**
     * Yes/No Grid value
     * @param $value
     * @return string
     */
    public function getYesNoValue($value) {
        $array = $this->getYesNo();
        return $array[$value];
    }
    
    /**
     * Style Grid array
     * 
     * @return array
     */
    public function getStyle() {
        return array(
            'static'        => Mage::helper('xigen_bannermanager')->__('Static'),
            'single-static' => Mage::helper('xigen_bannermanager')->__('Single Static'),
            'bootstrap'     => Mage::helper('xigen_bannermanager')->__('Bootstrap'),
        );
    }
    
    /**
     * Style Grid value
     * @param $value
     * @return string
     */
    public function getStyleValue($value) {
        $array = $this->getYesNo();
        return $array[$value];
    }
    
    /**
     * Random/orderly Grid array
     * 
     * @return array
     */
    public function getRandomOrderly() {
        return array(
            'random'    => Mage::helper('xigen_bannermanager')->__('Random'),
            'orderly'   => Mage::helper('xigen_bannermanager')->__('Orderly'),
        );
    }
    
    /**
     * Random/orderly Grid value
     * @param $value
     * @return string
     */
    public function getRandomOrderlyValue($value) {
        $array = $this->getRandomOrderly();
        return $array[$value];
    }
    
    /**
     * Load sliders
     * 
     * @return Xigen_Bannermanager_Model_Resource_Slider_Collection
     */
    public function getSliders() {
        $this->_sliderPrefix = Mage::helper('xigen_bannermanager/database')->getSliderPrefix();
        $slidersCollection = Mage::getModel('xigen_bannermanager/slider')
                ->getCollection()
                ->addFieldToSelect($this->_sliderPrefix . 'id')
                ->addFieldToSelect($this->_sliderPrefix . 'title');

        return $slidersCollection;
    }

    /**
     * Load sliders into grid array
     * 
     * @return array
     */
    public function getSlidersArray() {
        $_sliders = $this->getSliders();
        $options_array = array();
        foreach ($_sliders as $slider) {
            $options_array[$slider->getSliderId()] = $slider->getSliderTitle();
        }
        return $options_array;
    }
    
    /**
     * Get Position Block Ids
     * @return array
     */
    public function getPostion() {
        return array(
            array(
                'label' => $this->__('------- Position -------'),
                'value' => ''
            ),
            array(
                'label' => $this->__('Default for using in CMS page template'),
                'value' => array(
                    array('value' => 'custom', 'label' => $this->__('Custom')),
            )),
            array(
                'label' => $this->__('Popular positions'),
                'value' => array(
                    array('value' => 'cms-page-content-top', 'label' => $this->__('Homepage-Content-Top')),
            )),
            array(
                'label' => $this->__('General (will be disaplyed on all pages)'),
                'value' => array(
                    array('value' => 'sidebar-right-top', 'label' => $this->__('Sidebar-Top-Right')),
                    array('value' => 'sidebar-right-bottom', 'label' => $this->__('Sidebar-Bottom-Right')),
                    array('value' => 'sidebar-left-top', 'label' => $this->__('Sidebar-Top-Left')),
                    array('value' => 'sidebar-left-bottom', 'label' => $this->__('Sidebar-Bottom-Left')),
                    array('value' => 'content-top', 'label' => $this->__('Content-Top')),
                    array('value' => 'menu-top', 'label' => $this->__('Menu-Top')),
                    array('value' => 'menu-bottom', 'label' => $this->__('Menu-Bottom')),
                    array('value' => 'page-bottom', 'label' => $this->__('Page-Bottom')),
            )),
            array(
                'label' => $this->__('Catalog and product'),
                'value' => array(
                    array('value' => 'catalog-sidebar-right-top', 'label' => $this->__('Catalog-Sidebar-Top-Right')),
                    array('value' => 'catalog-sidebar-right-bottom', 'label' => $this->__('Catalog-Sidebar-Bottom-Right')),
                    array('value' => 'catalog-sidebar-left-top', 'label' => $this->__('Catalog-Sidebar-Top-Left')),
                    array('value' => 'catalog-sidebar-left-bottom', 'label' => $this->__('Catalog-Sidebar-Bottom-Left')),
                    array('value' => 'catalog-content-top', 'label' => $this->__('Catalog-Content-Top')),
                    array('value' => 'catalog-menu-top', 'label' => $this->__('Catalog-Menu-Top')),
                    array('value' => 'catalog-menu-bottom', 'label' => $this->__('Catalog-Menu-Bottom')),
                    array('value' => 'catalog-page-bottom', 'label' => $this->__('Catalog-Page-Bottom')),
            )),
            array(
                'label' => $this->__('Category only'),
                'value' => array(
                    array('value' => 'category-sidebar-right-top', 'label' => $this->__('Category-Sidebar-Top-Right')),
                    array('value' => 'category-sidebar-right-bottom', 'label' => $this->__('Category-Sidebar-Bottom-Right')),
                    array('value' => 'category-sidebar-left-top', 'label' => $this->__('Category-Sidebar-Top-Left')),
                    array('value' => 'category-sidebar-left-bottom', 'label' => $this->__('Category-Sidebar-Bottom-Left')),
                    array('value' => 'category-content-top', 'label' => $this->__('Category-Content-Top')),
                    array('value' => 'category-menu-top', 'label' => $this->__('Category-Menu-Top')),
                    array('value' => 'category-menu-bottom', 'label' => $this->__('Category-Menu-Bottom')),
                    array('value' => 'category-page-bottom', 'label' => $this->__('Category-Page-Bottom')),
            )),
            array(
                'label' => $this->__('Product only'),
                'value' => array(
                    array('value' => 'product-sidebar-right-top', 'label' => $this->__('Product-Sidebar-Top-Right')),
                    array('value' => 'product-sidebar-right-bottom', 'label' => $this->__('Product-Sidebar-Bottom-Right')),
                    array('value' => 'product-sidebar-left-top', 'label' => $this->__('Product-Sidebar-Top-Left')),
                    array('value' => 'product-content-top', 'label' => $this->__('Product-Content-Top')),
                    array('value' => 'product-menu-top', 'label' => $this->__('Product-Menu-Top')),
                    array('value' => 'product-menu-bottom', 'label' => $this->__('Product-Menu-Bottom')),
                    array('value' => 'product-page-bottom', 'label' => $this->__('Product-Page-Bottom')),
            )),
            array(
                'label' => $this->__('Customer'),
                'value' => array(
                    array('value' => 'customer-content-top', 'label' => $this->__('Customer-Content-Top')),
            )),
            array(
                'label' => $this->__('Cart & Checkout'),
                'value' => array(
                    array('value' => 'cart-content-top', 'label' => $this->__('Cart-Content-Top')),
                    array('value' => 'checkout-content-top', 'label' => $this->__('Checkout-Content-Top')),
            )),
        );
    }
    
    /**
     * CMS page grid array
     * 
     * @return array
     */
    public function getPages() {
        
        $array = array(
            '' => $this->__('------- Optional page -------'),
        );
        
        $collection = Mage::getModel('cms/page')->getCollection()
            ->addFieldToFilter('is_active', 1);
        foreach($collection as $item) {
            $array[$item->getIdentifier()] = $item->getTitle();
        }
        
        return $array;
    }
    
}
