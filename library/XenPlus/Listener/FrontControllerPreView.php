<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_FrontControllerPreView
{
	/**
	 * Called before attempting to prepare a view in the front controller. 
	 * This could also be considered post-dispatch (after completing the dispatch loop).
	 * 
	 * @param  XenForo_FrontController             $fc                  - the front controller instance. From this, you can 
	 *                                                                  inspect the request, response, dependency loader, etc.
	 * @param  XenForo_ControllerResponse_Abstract &$controllerResponse 
	 * @param  XenForo_ViewRenderer_Abstract       &$viewRenderer       
	 * @param  array                               &$containerParams    - list of key-value parameters that will be used to help 
	 *                                                                  prepare/render the necessary container template.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_FrontController $fc,
    	XenForo_ControllerResponse_Abstract &$controllerResponse,
    	XenForo_ViewRenderer_Abstract &$viewRenderer, 
    	array &$containerParams);
}