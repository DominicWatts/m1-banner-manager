<?php

/**
 * Banner List admin edit form tabs block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    /**
     * Initialize tabs and define tabs block settings
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('xigen_bannermanager')->__('Banner Item'));
    }

}
