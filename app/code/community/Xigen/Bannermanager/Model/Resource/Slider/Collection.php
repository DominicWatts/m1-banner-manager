<?php

/**
 * Slider collection
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Model_Resource_Slider_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Define collection model
     */
    protected function _construct()
    {
        $this->_init('xigen_bannermanager/slider');
    }
}
