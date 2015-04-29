<?php

/**
 * Slider list admin grid
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Slider_Grid extends Xigen_Bannermanager_Block_Adminhtml_Grid {

    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId($this->_sliderPrefix . 'list_grid');
        $this->setDefaultSort($this->_sliderPrefix . 'id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for Grid
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('xigen_bannermanager/slider')->getResourceCollection()
                ->addFieldToFilter($this->_sliderPrefix . 'is_trash', $this->_trashFilter);
        
        foreach ($collection as $view) {
            if ($view->getStoreId() && $view->getStoreId() != 0) {
                $view->setStoreId(explode(',', $view->getStoreId()));
            } else {
                $view->setStoreId(array('0'));
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Grid columns
     *
     * @return Xigen_Bannermanager_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn($this->_sliderPrefix . 'id', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('ID'),
            'width'     => '50px',
            'index'     => $this->_sliderPrefix . 'id',
        ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => Mage::helper('xigen_bannermanager')->__('Store View'),
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => true,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn($this->_sliderPrefix . 'title', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Title'),
            'index'     => $this->_sliderPrefix . 'title',
        ));
        
        $this->addColumn($this->_sliderPrefix . 'show_title', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'width'  => '50px',
            'frame_callback' => array($this, '_loadYesNo'),
            'index'     => $this->_sliderPrefix . 'show_title',
        ));
        
        $this->addColumn($this->_sliderPrefix . 'created_at', array(
            'header'   => Mage::helper('xigen_bannermanager')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => $this->_sliderPrefix . 'created_at',
            'type'     => 'datetime',
        ));

        $this->addColumn($this->_sliderPrefix . 'sort',array(
                 'header' => Mage::helper('xigen_bannermanager')->__('Sort Type'),
                 'align'  => 'left',
                 'width'  => '50px',
                 'index'  => $this->_sliderPrefix . 'sort',
        ));
        
        $this->addColumn($this->_sliderPrefix . 'is_active', array(
            'header'    => Mage::helper('xigen_bannermanager')->__('Is Active'),
            'width'  => '50px',
            'frame_callback' => array($this, '_loadYesNo'),
            'index'     => $this->_sliderPrefix . 'is_active',
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
     * @return Xigen_Bannermanager_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField($this->_sliderPrefix . 'id');
        $this->getMassactionBlock()->setFormFieldName($this->_sliderPrefix);

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
    
    /**
     * Filter store condition
     * @param Xigen_Bannermanager_Block_Adminhtml_Slider_Grid $collection
     * @param string $column
     * @return mixed
     */
    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }
    
}