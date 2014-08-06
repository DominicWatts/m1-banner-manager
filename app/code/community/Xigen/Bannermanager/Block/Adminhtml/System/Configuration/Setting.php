<?php

/**
 * Admin instructions block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_System_Configuration_Setting extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        return '<div class="entry-edit-head collapseable"><a onclick="Fieldset.toggleCollapse(\'bannermanager_template\'); return false;" href="#" id="bannermanager_template-head" class="open">Snippets</a></div>
                <input id="bannermanager_template-state" type="hidden" value="1" name="config_state[bannermanager_template]">
                <fieldset id="bannermanager_template" class="config collapseable" style="">
                <ul>
                    <li><strong>'.Mage::helper('xigen_bannermanager')->__('Template file').'</strong></li>	
                    <li>
                        <code>
                            &lt;?php echo $this->getLayout()->createBlock(\'xigen_bannermanager/slider\')->setTemplate(\'xigen/bannermanager/slider.phtml\')->setSliderId(\'your_slider_id\')->toHtml(); ?&gt;
                        </code>
                    </li>
                </ul>
                <br/>
                <ul>
                    <li><strong>'.Mage::helper('xigen_bannermanager')->__('CMS Page').'</strong></li>
                    <li>
                        <code>
                            {{block type="xigen_bannermanager/slider" name="xigen.bannermanager.slider" template="xigen/bannermanager/slider.phtml" slider_id="your_slider_id"}}
                        </code>
                    </li>
                </ul>
                <br/>
                <ul>
                    <li><strong>'.Mage::helper('xigen_bannermanager')->__('Layout XML').'</strong></li>
                    <li>
                        <code>
                         &lt;block type="xigen_bannermanager/slider" name="xigen.bannermanager.slider" template="xigen/bannermanager/slider.phtml"&gt;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;action method="setSliderId"&gt;&lt;slider_id&gt;your_slider_id&lt;/slider_id&gt;&lt;/action&gt;<br>
                        &lt;/block&gt;
                        </code>	
                    </li>
                </ul>';
    }
}
