<?php

/**
 * Slider Banner admin tab grid
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Slider_Edit_Tab_Banner extends Xigen_Bannermanager_Block_Adminhtml_Grid {

    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId($this->_bannerPrefix . 'Grid');
        $this->setUseAjax(true);
        $this->setDefaultSort($this->_bannerPrefix . 'created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(false);
    }

    /**
     * Prepare collection for Grid
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Grid
     */
    protected function _prepareCollection() {
        $slider_id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('xigen_bannermanager/banner')->getResourceCollection();
        $collection->addFieldToFilter($this->_bannerPrefix . 'slider_id', $slider_id);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column) {
        parent::_addColumnFilterToCollection($column);
        return $this;
    }

    protected function _prepareColumns() {

        $this->addColumn($this->_bannerPrefix . 'id', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('ID'),
            'width'     => '50px',
            'index'     => $this->_bannerPrefix . 'id',
        ));
       
        $this->addColumn($this->_bannerPrefix . 'title', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Banner Title'),
            'index'     => $this->_bannerPrefix . 'title',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'image', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Banner Image'),
            'index'     => $this->_bannerPrefix . 'image',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'youtube', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Banner Youtube'),
            'index'     => $this->_bannerPrefix . 'youtube',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'created_at', array(
            'header'   => Mage::helper('xigen_bannermanager')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => $this->_bannerPrefix . 'created_at',
            'type'     => 'datetime',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'sort_order',array(
                 'header' => Mage::helper('xigen_bannermanager')->__('Sort Order'),
                 'align'  => 'left',
                 'width'  => '50px',
                 'index'  => $this->_bannerPrefix . 'sort_order',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'is_active', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Is Active'),
            'width'  => '50px',
            'frame_callback' => array($this, '_loadYesNo'),
            'index'     => $this->_bannerPrefix . 'is_active',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'is_trash', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Is Trash'),
            'width'  => '50px',
            'frame_callback' => array($this, '_loadYesNo'),
            'index'     => $this->_bannerPrefix . 'is_trash',
        ));
              
        $this->addColumn('action', array(
            'header' => Mage::helper('xigen_bannermanager')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(array(
                    'caption' => Mage::helper('xigen_bannermanager')->__('Edit'),
                    'url' => array('base' => '*/bannermanager_banner/edit'),
                    'field' => 'id'
                )),
            'filter' => false,
            'sortable' => false,
            'index' => 'banner',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Return row URL for js event handlers
     * @param type $row
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/bannermanager_banner/edit', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl() {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/bannergrid', array('_current' => true));
    }

}
