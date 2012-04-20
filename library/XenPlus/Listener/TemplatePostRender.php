<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_TemplatePostRender
{
	/**
	 * Called after a template is rendered. Please note that this is only called for templates that are created via 
	 * the template object directly. Templates that are included via <xen:include> will not trigger this event.
	 * 
	 * @param  string                    $templateName   - the name of the template that was rendered
	 * @param  string                    &$content       - the final string output of the template
	 * @param  array                     &$containerData - data that this template rendered for use in the container template
	 * @param  XenForo_Template_Abstract $template       - the template object itself
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function execute($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template);
}