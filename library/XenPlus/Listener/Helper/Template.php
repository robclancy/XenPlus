<?php

/**
 * @package XenPlus_Listener
 */
class XenPlus_Listener_Helper_Template extends XenPlus_Listener_Helper_Abstract
{
	/**
	 * Turns a template or hook name into a camel case string... so xenforo_template_name into xenforoTemplateName.
	 * 
	 * @param  string $templateName
	 * 
	 * @return mixed - false if method doesn't exist in the listener, new method name if it does.
	 */
	public function getTemplateMethod($templateName)
	{
		$methodName = Zend_Filter::filterStatic($templateName, 'Word_UnderscoreToCamelCase');

		return method_exists($this->_listener, $methodName) ? $methodName : false;
	}

	/**
	 * Calls a method depending on what the template name is, if the method exists
	 * 
	 * @param  string $templateName 
	 * @param  mixed ... additional arguments that will be passed to the method
	 * @param  mixed ...
	 * ...
	 * 
	 * @return mixed null if no method to call otherwise returns whatever the method returns when called
	 */
	public function callTemplateMethod($templateName)
	{
		if ($methodName = $this->getTemplateMethod($templateName))
		{
			$args = func_get_args();
			array_shift($args);
			return call_user_func_array(array($this->_listener, $methodName), $args);
		}

		return null;
	}
}