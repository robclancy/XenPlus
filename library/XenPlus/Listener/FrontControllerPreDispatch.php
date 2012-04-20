<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_FrontControllerPreDispatch
{
	/**
	 * Called before attempting to dispatch the request in the front controller. This could also be considered post-routing.
	 * 
	 * @param XenForo_FrontController $fc          - the front controller instance. From this, you can inspect the request, response, dependency loader, etc.
	 * @param XenForo_RouteMatch 	  &$routeMatch - the route match object. Note that this may represent an error page if routing was unsuccessful.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_FrontController $fc, XenForo_RouteMatch &$routeMatch);
}