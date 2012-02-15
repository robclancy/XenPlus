<?php

abstract class XenPlus_Listener_TemplatePostRender extends XenPlus_Listener_Abstract
{
    protected $_template;

    public function execute($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template)
    {
        $this->_template = $template;

        $method = '_' . XenPlus_Helper_Listener::convertToCamelCase($templateName);
        if (method_exists($this, $method))
            $this->$method($content, $containerData);
    }
}