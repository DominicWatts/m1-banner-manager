<?php

/**
 * Slider List admin edit form tabs block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    /**
     * Initialize tabs and define tabs block settings
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('xigen_bannermanager')->__('Slider Item'));
    }
    
     /**
     * Add banners tabs
     *
     */
    protected function _beforeToHtml() {        
        $this->addTab('form_section', array(
            'label' => Mage::helper('xigen_bannermanager')->__('Banners'),
            'title' => Mage::helper('xigen_bannermanager')->__('Banners'),
            'url' => $this->getUrl('*/*/banner', array('_current' => true)),
            'class' => 'ajax',
        ));

        return parent::_beforeToHtml();
    }

}
