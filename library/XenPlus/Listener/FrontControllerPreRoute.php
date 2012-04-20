<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_FrontControllerPreRoute
{
	/**
	 * Called before attempting to route the request in the front controller.
	 * 
	 * @param XenForo_FrontController $fc      - the front controller instance. From this, you can inspect the request, response, dependency loader, etc.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_FrontController $fc);
}