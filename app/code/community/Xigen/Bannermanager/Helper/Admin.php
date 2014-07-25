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
     * Random/orderly Grid array
     * 
     * @return array
     */
    public function getRandomOrderly() {
        return array(
            'random' => Mage::helper('xigen_bannermanager')->__('Random'),
            'orderly' => Mage::helper('xigen_bannermanager')->__('Orderly'),
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

}
