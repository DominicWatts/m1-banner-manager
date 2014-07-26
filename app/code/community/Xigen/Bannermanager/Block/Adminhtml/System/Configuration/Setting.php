<?php

/**
 * Admin instructions block
 *
 * @author Xigen
 */
class Xigen_Bannermanager_Block_Adminhtml_System_Configuration_Setting extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        return '<div class="entry-edit-head collapseable"><a onclick="Fieldset.toggleCollapse(\'bannermanager_template\'); return false;" href="#" id="bannermanager_template-head" class="open">Generate Banner</a></div>
                <input id="bannermanager_template-state" type="hidden" value="1" name="config_state[bannermanager_template]">
                <fieldset id="bannermanager_template" class="config collapseable" style="">
                <div id="messages">
                    <ul class="messages">
                        <li class="notice-msg">
                            <ul>
                                <li>'.Mage::helper('xigen_bannermanager')->__('Add code below to a template file').'</li>				
                            </ul>
                        </li>
                    </ul>
                </div>
                <br>
                <ul>
                    <li>
                        <code>
                            $this->getLayout()->createBlock(xigen_bannermanager/slider)->setTemplate(\'xigen/bannermanager/slider.phtml\')->setSliderId(\'your_slider_id\')->toHtml();
                        </code>
                    </li>
                </ul>
                <br>
                <div id="messages">
                    <ul class="messages">
                        <li class="notice-msg">
                            <ul>
                                <li>'.Mage::helper('xigen_bannermanager')->__('You can put a banner slider on a cms page. Below is an example which we put a banner slider with bannermanager_id is your_slider_id on a cms page').'</li>				
                            </ul>
                        </li>
                    </ul>
                </div>
                <br>
                <ul>
                    <li>
                        <code>
                            {{block type="xigen_bannermanager/slider" name="xigen.bannermanager.slider" template="xigen/bannermanager/slider.phtml" bannermanager_id="your_slider_id"}}
                        </code>
                    </li>
                </ul>
                <br>
                <div id="messages">
                    <ul class="messages">
                        <li class="notice-msg">
                            <ul>
                                <li>'.Mage::helper('xigen_bannermanager')->__('Please copy and paste the code below on one of xml layout files where you want to show the banner. Please replace the your_slider_ids variable with your own bannermanager Id').'</li>				
                            </ul>
                        </li>
                    </ul>
                </div>

                <ul>
                    <li>
                        <code>
                         &lt;block type="xigen_bannermanager/slider" name="xigen.bannermanager.slider" template="xigen/bannermanager/slider.phtml"&gt;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;action method="setSliderId"&gt;&lt;bannermanager_id&gt;your_slider_id&lt;/bannermanager_id&gt;&lt;/action&gt;<br>
                        &lt;/block&gt;
                        </code>	
                    </li>
                </ul>';
    }
}
