<?php

abstract class XenPlus_Listener_TemplateCreate extends XenPlus_Listener_Abstract
{
    protected $_template;

    public function execute(&$templateName, array &$params, XenForo_Template_Abstract $template)
    {
        $this->_template = $template;

        $method = '_' . XenPlus_Helper_Listener::convertToCamelCase($templateName);
        if (method_exists($this, $method))
            $this->$method($templateName, $params);

		if (method_exists($this, '_preLoadTemplates'))
		{
			$templates = $this->_preLoadTemplates();
			if (isset($templates[$templateName]))
			{
				if (!is_array($templates[$templateName]))
					$templates[$templateName] = array($templates[$templateName]);

				foreach ($templates[$templateName] as $temp)
					$template->preloadTemplate($temp);
			}
		}
    }
}