<?php

/**
 * Banner model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Banner extends Xigen_Bannermanager_Model_Abstract {

    /**
     * Define resource model
     */
    public function _construct() {
        $this->_init('xigen_bannermanager/banner');
        parent::_construct();
    }

    /**
     * If object is new adds creation date
     *
     * @return Xigen_Bannermanager_Model_Banner
     */
    protected function _beforeSave() {
        parent::_beforeSave();
        if ($this->isObjectNew()) {
            $this->setData($this->_bannerPrefix . 'created_at', Varien_Date::now());
        }
        return $this;
    }

}
