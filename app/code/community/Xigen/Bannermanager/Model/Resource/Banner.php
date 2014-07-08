<?php

/**
 * Banner resource model
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Resource_Banner extends Xigen_Bannermanager_Model_Resource_Abstract {

    /**
     * Initialize connection and define main table and primary key
     */
    protected function _construct() {
        parent::_construct();
        $this->_init('xigen_bannermanager/banner', $this->_bannerPrefix . 'id');
    }

}
