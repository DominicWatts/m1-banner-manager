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
        
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('xigen_bannermanager')->__('Store View'),
                'title' => Mage::helper('xigen_bannermanager')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId(),
            ));
        }
        
        $fieldset->addField($this->_sliderPrefix . 'position', 'select', array(
            'name'     => $this->_sliderPrefix . 'position',
            'label'    => Mage::helper('xigen_bannermanager')->__('Position'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Position'),
            'required' => true,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getPostion(),
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField($this->_sliderPrefix . 'page', 'select', array(
            'name'     => $this->_sliderPrefix . 'page',
            'label'    => Mage::helper('xigen_bannermanager')->__('Page'),
            'title'    => Mage::helper('xigen_bannermanager')->__('Page'),
            'required' => false,
            'values'   => Mage::helper('xigen_bannermanager/admin')->getPages(),
            'disabled' => $isElementDisabled
        ));
        
        $categoryIds = implode(",", Mage::getResourceModel('catalog/category_collection')
             ->addFieldToFilter('level', array('gt' => 0))
             ->getAllIds());
        
        $fieldset->addField('category_id', 'text', array(
            'label'     => Mage::helper('xigen_bannermanager')->__('Categories'),
            'name'      => 'category_id',
            'disabled'  => $isElementDisabled,
            'after_element_html' => 
                '<a id="category_link" href="javascript:void(0)" onclick="toggleMainCategories()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Categories"></a>
                <div  id="categories_check">
                    <a href="javascript:toggleMainCategories(\'checkall\')">Check All</a> / <a href="javascript:toggleMainCategories(\'uncheckall\')">Uncheck All</a>
                </div>
                <div id="main_categories_select" style="display:none"></div>
                <script type="text/javascript">
                function toggleMainCategories(check){
                    var categories_select = $("main_categories_select");
                    if($("main_categories_select").style.display == "none" || (check == "checkall") || (check == "uncheckall")){
                        $("categories_check").style.display ="";
                        var url = "' . $this->getUrl('adminhtml/bannermanager_slider/chooserMainCategories') . '";
                        if(check == "checkall"){
                            $("slider_main_category_id").value = "' . $categoryIds . '";
                        }else if(check == "uncheckall"){
                            $("slider_main_category_id").value = "";
                        }
                        var params = $("slider_main_category_id").value.split(",");
                        var parameters = {"form_key": FORM_KEY,"selected[]":params };
                        var request = new Ajax.Request(url,
                            {
                                evalScripts: true,
                                parameters: parameters,
                                onComplete:function(transport){
                                    $("main_categories_select").update(transport.responseText);
                                    $("main_categories_select").style.display = "block"; 
                                }
                            });
                        if(categories_select.style.display == "none"){
                            categories_select.style.display = "";
                        }else{
                            categories_select.style.display = "none";
                        } 
                    }else{
                        categories_select.style.display = "none";
                        $("categories_check").style.display ="none";
                    }
                };
                </script>'
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
