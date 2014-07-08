<?php
/**
 * Banner List admin edit form container
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit form container
     *
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'xigen_bannermanager';
        $this->_controller = 'adminhtml_banner';

         parent::__construct();
        
        $bannerId     = $this->getRequest()->getParam('id');
        $_banner      = Mage::getModel('xigen_bannermanager/banner')->load($bannerId);

        if($_banner->getBannerIsTrash()) {
            
            $this->_removeButton('save');
            if($this->_updateButton('delete', 'label', Mage::helper('xigen_bannermanager')->__('Delete Banner'))) {
                $this->_updateButton('delete', 'label', Mage::helper('xigen_bannermanager')->__('Delete Banner'));
            }
            
        } else {
        
            if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('save')) {
                $this->_updateButton('save', 'label', Mage::helper('xigen_bannermanager')->__('Save Banner'));
                $this->_addButton('saveandcontinue', array(
                    'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                    'onclick' => 'saveAndContinueEdit()',
                    'class'   => 'save',
                ), -100);
            } else {
                $this->_removeButton('save');
            }

            if (Mage::helper('xigen_bannermanager/admin')->isActionAllowed('delete')) {
                 $this->_addButton('trash', array(
                    'label'     => Mage::helper('xigen_bannermanager')->__('Trash'),
                    'onclick'   => "setLocation('{$this->getUrl('*/*/trash', array('id' => $bannerId))}')",
                    'class'     => 'delete',
                ));
                $this->_removeButton('delete');
            } else {
                $this->_removeButton('delete');
            }
        }
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        $model = Mage::helper('xigen_bannermanager')->getBannerInstance();
        if ($model->getId()) {
            return Mage::helper('xigen_bannermanager')->__("Edit '%s'",
                 $this->escapeHtml($model->getBannerTitle()));
        } else {
            return Mage::helper('xigen_bannermanager')->__('New Banner');
        }
    }
}