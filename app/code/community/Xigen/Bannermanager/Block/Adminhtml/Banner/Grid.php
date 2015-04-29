<?php

/**
 * Banner list admin grid
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Grid extends Xigen_Bannermanager_Block_Adminhtml_Grid {

    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId($this->_bannerPrefix . 'list_grid');
        $this->setDefaultSort($this->_bannerPrefix . 'slider_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for Grid
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('xigen_bannermanager/banner')->getResourceCollection()
                ->addFieldToFilter($this->_bannerPrefix . 'is_trash', $this->_trashFilter);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Grid columns
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn($this->_bannerPrefix . 'id', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('ID'),
            'width'     => '50px',
            'index'     => $this->_bannerPrefix . 'id',
        ));

        $this->addColumn($this->_bannerPrefix . 'title', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Title'),
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
        
        $this->addColumn($this->_bannerPrefix . 'show_title', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'width'  => '50px',
            'frame_callback' => array($this, '_loadYesNo'),
            'index'     => $this->_bannerPrefix . 'show_title',
        ));
        
        $this->addColumn($this->_bannerPrefix . 'created_at', array(
            'header'   => Mage::helper('xigen_bannermanager')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => $this->_bannerPrefix . 'created_at',
            'type'     => 'datetime',
        ));

        $this->addColumn($this->_bannerPrefix . 'slider_id', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Slider'),
            'frame_callback' => array($this, '_loadSlider'),
            'index'     => $this->_bannerPrefix . 'slider_id',
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
        
        if ($this->_trashFilter) {
            $this->addColumn('action', array(
                'header' => Mage::helper('xigen_bannermanager')->__('Action'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('xigen_bannermanager')->__('Delete'),
                        'url' => array('base' => '*/*/delete'),
                        'field' => 'id'
                    ),
                    array(
                        'caption' => Mage::helper('xigen_bannermanager')->__('Restore'),
                        'url' => array('base' => '*/*/restore'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'post',
            ));
        } else {
            $this->addColumn('action', array(
                'header' => Mage::helper('xigen_bannermanager')->__('Action'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('xigen_bannermanager')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    ),
                    array(
                        'caption' => Mage::helper('xigen_bannermanager')->__('Trash'),
                        'url' => array('base' => '*/*/trash'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'post',
            ));
        }

        return parent::_prepareColumns();
    }
    
    /**
     * Add mass-actions to grid
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField($this->_bannerPrefix . 'id');
        $this->getMassactionBlock()->setFormFieldName($this->_bannerPrefix);

        if ($this->_trashFilter) {
            $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('xigen_bannermanager')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('xigen_bannermanager')->__('Are you sure?')
            ));
            $this->getMassactionBlock()->addItem('restore', array(
                'label' => Mage::helper('xigen_bannermanager')->__('Restore'),
                'url' => $this->getUrl('*/*/massRestore'),
                'confirm' => Mage::helper('xigen_bannermanager')->__('Are you sure?')
            ));
        } else {
            $this->getMassactionBlock()->addItem('trash', array(
                'label' => Mage::helper('xigen_bannermanager')->__('Trash'),
                'url' => $this->getUrl('*/*/massTrash'),
                'confirm' => Mage::helper('xigen_bannermanager')->__('Are you sure?')
            ));
        }
            
        return $this;
    }
    
}