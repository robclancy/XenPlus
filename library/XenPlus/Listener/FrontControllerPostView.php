<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_FrontControllerPostView
{
	/**
	 * Called after the view has been executed, before outputting. This can be used to modify the final output.
	 * 
	 * @param XenForo_FrontController $fc      - the front controller instance. From this, you can inspect the request, response, dependency loader, etc.
	 * @param [type]                  &$output - string to output. Note that this may not be HTML or even text.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_FrontController $fc, &$output);
}