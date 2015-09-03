<?php

/**
 * Banner List admin edit form main tab
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Edit_Tab_Main extends Xigen_Bannermanager_Block_Adminhtml_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface {

    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::helper('xigen_bannermanager')->getBannerInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix($this->_bannerPrefix . 'main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('xigen_bannermanager')->__('Banner Item'),
            'class'  => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField($this->_bannerPrefix . 'id', 'hidden', array(
                'name' => $this->_bannerPrefix . 'id',
            ));
        }
        
        $fieldset->addField($this->_bannerPrefix . 'is_active', 'select', array(
            'name'     => $this->_bannerPrefix . 'is_active',
            'label'    => Mage::helper('xigen_bannermanager')->__('Enable'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Enable'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getYesNo(),
            'disabled' => $isElementDisabled
        ));
         
        $fieldset->addField($this->_bannerPrefix . 'title', 'text', array(
            'name'     => $this->_bannerPrefix . 'title',
            'label'    => Mage::helper('xigen_bannermanager')->__('Banner Title'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Banner Title'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_bannerPrefix . 'youtube', 'text', array(
            'name'     => $this->_bannerPrefix . 'youtube',
            'label'    => Mage::helper('xigen_bannermanager')->__('Youtube'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Youtube'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_bannerPrefix . 'show_title', 'select', array(
            'name'     => $this->_bannerPrefix . 'show_title',
            'label'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Show Title'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getYesNo(),
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_bannerPrefix . 'sort_order', 'text', array(
            'name'     => $this->_bannerPrefix . 'sort_order',
            'label'    => Mage::helper('xigen_bannermanager')->__('Sort Order'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Sort Order'),
            'disabled' => $isElementDisabled
        ));
        
        $validationErrorMessage = addslashes(Mage::helper('xigen_bannermanager')->__("Please use only letters (a-z or A-Z), numbers (0-9) or symbols '-', '_', '\', '/', '#' and ':' in this field"));

        $fieldset->addField($this->_bannerPrefix . 'link', 'text', array(
            'name'               => $this->_bannerPrefix . 'link',            
            'label'              => Mage::helper('xigen_bannermanager')->__('Link'),
            'title'              => Mage::helper('xigen_bannermanager')->__('Link'),
            'class'              => 'xigen-bannermanager-validate-link',
            'index'              => $this->_bannerPrefix . 'link',
            'after_element_html' =>   "<script>
                                       Validation.add(
                                           'xigen-bannermanager-validate-link',
                                           '" . $validationErrorMessage . "',
                                           function (v) {
                                               return Validation.get('IsEmpty').test(v) || (/^[\/\a-zA-Z0-9_\-#:]+$/).test(v);
                                           }
                                       );
                                       </script>",
        ));
        
        $fieldset->addField($this->_bannerPrefix . 'slider_id', 'select', array(
            'name'     => $this->_bannerPrefix . 'slider_id',
            'label'    => Mage::helper('xigen_bannermanager')->__('Slider'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Slider'),
            'required' => true,
            'value'    => '',
            'values'   => Mage::helper('xigen_bannermanager/admin')->getSlidersArray(),
            'disabled' => $isElementDisabled
        ));
         
         $fieldset->addField($this->_bannerPrefix . 'caption_note', 'note', array(
            'label'    => Mage::helper('xigen_bannermanager')->__('Banner Caption'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Banner Caption'),
        ));
        
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array(
            'tab_id' => $this->getTabId()
        ));

        $contentField = $fieldset->addField($this->_bannerPrefix . 'caption', 'editor', array(
            'name'     => $this->_bannerPrefix . 'caption',
            'label'    => Mage::helper('xigen_bannermanager')->__('Banner Caption'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Banner Caption'),
            'style'    => 'height:60px;',
            'required' => false,
            'disabled' => $isElementDisabled,
            'config'   => $wysiwygConfig
        ));

        // Setting custom renderer for content field to remove label column
        $renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
            ->setTemplate('cms/page/edit/form/renderer/content.phtml');
        $contentField->setRenderer($renderer);
        
        Mage::dispatchEvent('adminhtml_banner_edit_tab_main_prepare_form', array('form' => $form));

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
        return Mage::helper('xigen_bannermanager')->__('Banner Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('xigen_bannermanager')->__('Banner Info');
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
