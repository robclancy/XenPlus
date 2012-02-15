<?php

abstract class XenPlus_Listener_TemplateHook extends XenPlus_Listener_Abstract
{
    protected $_template;
    protected $_hookParams;

    public function execute($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
    {
        $this->_template = $template;
        $this->_hookParams = $hookParams;

        $method = '_' . XenPlus_Helper_Listener::convertToCamelCase($hookName);
        if (method_exists($this, $method))
            $this->$method($contents);
    }
}