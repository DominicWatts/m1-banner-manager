<?php

/**
 * Banner List admin grid container
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Block constructor
     */
    public function __construct() {
        $this->_blockGroup = 'xigen_bannermanager';
        $this->_controller = 'adminhtml_banner';

        parent::__construct();

        $this->_trashFilter = $this->getRequest()->getParam('is_trash');
        if($this->_trashFilter) {
            $this->_headerText = Mage::helper('xigen_bannermanager')->__('Banners In Trash');
        } else {
            $this->_headerText = Mage::helper('xigen_bannermanager')->__('Banners');
        }
        
        if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('save')) {
            $this->_updateButton('add', 'label', Mage::helper('xigen_bannermanager')->__('Add New Banner'));
        } else {
            $this->_removeButton('add');
        }
        
        if($this->_trashFilter) {
            $this->_addButton('view_comments', array(
                'label'     => Mage::helper('xigen_bannermanager')->__('View Banners'),
                'onclick'   => "setLocation('{$this->getUrl('*/*/*')}')",
                'class'     => 'add'
            ), 0, 100, 'header', 'header');
        } else {
            $this->_addButton('view_trash', array(
                'label'     => Mage::helper('xigen_bannermanager')->__('View Trash'),
                'onclick'   => "setLocation('{$this->getUrl('*/*/*', array('is_trash' => '1'))}')",
                'class'     => 'add'
            ), 0, 100, 'header', 'header'); 
        }
    }
}