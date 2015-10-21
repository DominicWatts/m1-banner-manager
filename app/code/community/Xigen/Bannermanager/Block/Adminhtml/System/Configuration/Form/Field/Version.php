<?php

class Xigen_Bannermanager_Block_Adminhtml_System_Configuration_Form_Field_Version extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface {

    /**
     * Render element html
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $useContainerId = $element->getData('use_container_id');
        return sprintf('<tr id="row_%s">'
                        . '<td class="label"><label for="%s">%s</label></td>'
                        . '<td class="value">%s</td>'
                      . '</tr>', $element->getHtmlId(), $element->getHtmlId(), $element->getLabel(), Mage::getConfig()->getModuleConfig("Xigen_Bannermanager")->version);
    }

}
