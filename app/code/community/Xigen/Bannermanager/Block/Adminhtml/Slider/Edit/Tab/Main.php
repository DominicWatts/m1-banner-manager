<?php

/**
 * Slider List admin edit form main tab
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Slider_Edit_Tab_Main extends Xigen_Bannermanager_Block_Adminhtml_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::helper('xigen_bannermanager')->getSliderInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix($this->_sliderPrefix . 'main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('xigen_bannermanager')->__('Slider Item'),
            'class'  => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField($this->_sliderPrefix . 'id', 'hidden', array(
                'name' => $this->_sliderPrefix . 'id',
            ));
        }
        
        $fieldset->addField($this->_sliderPrefix . 'is_active', 'select', array(
            'name'     => $this->_sliderPrefix . 'is_active',
            'label'    => Mage::helper('xigen_bannermanager')->__('Enable'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Enable'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getYesNo(),
            'disabled' => $isElementDisabled
        ));
         
        $fieldset->addField($this->_sliderPrefix . 'title', 'text', array(
            'name'     => $this->_sliderPrefix . 'title',
            'label'    => Mage::helper('xigen_bannermanager')->__('Slider Title'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Slider Title'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_sliderPrefix . 'show_title', 'select', array(
            'name'     => $this->_sliderPrefix . 'show_title',
            'label'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getYesNo(),
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_sliderPrefix . 'style', 'select', array(
            'name'     => $this->_sliderPrefix . 'style',
            'label'    => Mage::helper('xigen_bannermanager')->__('Style'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Style'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getStyle(),
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_sliderPrefix . 'sort', 'select', array(
            'name'     => $this->_sliderPrefix . 'sort',
            'label'    => Mage::helper('xigen_bannermanager')->__('Sort Type'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Sort Type'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getRandomOrderly(),
            'disabled' => $isElementDisabled
        ));
        
        Mage::dispatchEvent('adminhtml_slider_edit_tab_main_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('xigen_bannermanager')->__('Slider Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('xigen_bannermanager')->__('Slider Info');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
}
