<?php
/**
 * Banner List admin edit form image tab
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Edit_Tab_Image extends Xigen_Bannermanager_Block_Adminhtml_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Prepare form elements
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix($this->_bannerPrefix . 'image_');

        $model = Mage::helper('xigen_bannermanager')->getBannerInstance();


        /* @var $imageHelper Xigen_Bannermanager_Helper_Image */
        $imageHelper = Mage::helper('xigen_bannermanager/image');
        
        if($model->getBannerImage()) {
            $fieldset = $form->addFieldset('image_preview', array(
                'legend'    => Mage::helper('xigen_bannermanager')->__('Image Preview'), 'class' => 'fieldset-wide'
            ));

            $fieldset->addField('preview', 'note', array(
                'name'      => 'preview',
                'label'     => Mage::helper('xigen_bannermanager')->__('Image Preview'),
                'title'     => Mage::helper('xigen_bannermanager')->__('Image Preview'),
                'after_element_html' => '<img src="' . $imageHelper->getBaseUrl() . $model->getBannerImage() . '" width="500" alt="' . $model->getBannerImage() . '" title="' . $model->getBannerImage() . '"/>',
                'required'  => false,
                'disabled'  => $isElementDisabled
            ));
        }
        
        $fieldset = $form->addFieldset('image_fieldset', array(
            'legend'    => Mage::helper('xigen_bannermanager')->__('Image Thumbnail'), 'class' => 'fieldset-wide'
        ));

        $this->_addElementTypes($fieldset);

        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => Mage::helper('xigen_bannermanager')->__('Image'),
            'title'     => Mage::helper('xigen_bannermanager')->__('Image'),
            'required'  => false,
            'disabled'  => $isElementDisabled
        ));

        Mage::dispatchEvent('adminhtml_banner_edit_tab_image_prepare_form', array('form' => $form));

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
        return Mage::helper('xigen_bannermanager')->__('Image Thumbnail');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('xigen_bannermanager')->__('Image Thumbnail');
    }

    /**
     * Returns status flag about this tab can be showen or not
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

    /**
     * Retrieve predefined additional element types
     *
     * @return array
     */
     protected function _getAdditionalElementTypes()
     {
         return array(
            'image' => Mage::getConfig()->getBlockClassName('xigen_bannermanager/adminhtml_banner_edit_form_element_image')
        );
     }
}