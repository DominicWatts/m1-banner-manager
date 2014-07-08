<?php
/**
 * Custom image form element that generates correct thumbnail image URL
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_Banner_Edit_Form_Element_Image extends Varien_Data_Form_Element_Image
{
    /**
     * Get image preview url
     *
     * @return string
     */
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('xigen_bannermanager/image')->getBaseUrl() . '/' . $this->getValue();
        }
        return $url;
    }
}