<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_FileHealthCheck
{
	/**
	 * Called before the operation of the 'File Health Check' tool.
	 * You may use this event to provide the hashes of the required files from your own add-on, 
	 * so that your add-on can be health-checked along with the core code.
	 * 
	 * You should generate your hashes using XenForo_Helper_Hash::hashDirectory() against your add-on's directories, 
	 * then assemble a $hashes array and build it into a class using XenForo_Helper_Hash::getHashClassCode(), 
	 * so that you end up with a result similar to XenForo_Install_Data_FileSums.
	 * 
	 * @param  XenForo_ControllerAdmin_Abstract $controller - the controller calling the event.
	 * @param  array                            &$hashes    - the array of file hashes for your add-on. Keys should be the path 
	 *                                                      to the file relative to the installation directory, and values should 
	 *                                                      be the MD5 sum of the file contents.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_ControllerAdmin_Abstract $controller, array &$hashes);
}