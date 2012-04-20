<?php

interface XenPlus_Listener_TemplateCreate
{
	/**
	 * Called whenever the template object constructor is called. You may use this event to modify 
	 * the name of the template being called, to modify the params being passed to the template, 
	 * or to pre-load additional templates as needed.
	 * 
	 * @param  string                    &$templateName - the name of the template to be rendered.
	 * @param  array                     &$params       - key-value pairs of parameters that are available to the template.
	 * @param  XenForo_Template_Abstract $template      - the template object itself.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(&$templateName, array &$params, XenForo_Template_Abstract $template);
}