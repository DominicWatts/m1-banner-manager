<?php

/**
 * Slider model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Slider extends Xigen_Bannermanager_Model_Abstract {

    /**
     * Define resource model
     */
    public function _construct() {
        $this->_init('xigen_bannermanager/slider');
        parent::_construct();
    }

    /**
     * If object is new adds creation date
     *
     * @return Xigen_Bannermanager_Model_Slider
     */
    protected function _beforeSave() {
        parent::_beforeSave();
        if ($this->isObjectNew()) {
            $this->setData($this->_sliderPrefix . 'created_at', Varien_Date::now());
        }
        return $this;
    }

}
