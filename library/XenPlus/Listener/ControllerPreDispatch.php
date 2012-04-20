<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_ControllerPreDispatch extends XenPlus_Listener_Abstract
{
	/**
	 * Called before attempting to dispatch the request in a specific controller. The visitor object is available at this point.
	 * 
	 * @param  XenForo_Controller $controller - the controller instance. From this, you can inspect the request, response, etc.
	 * @param  string             $action     - the specific action that will be executed in this controller.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    abstract public function execute(XenForo_Controller $controller, $action);
}