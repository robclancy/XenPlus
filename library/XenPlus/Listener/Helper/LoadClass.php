<?php

/**
 * @package XenPlus_Listener
 */
class XenPlus_Listener_Helper_LoadClass extends XenPlus_Listener_Helper_Abstract
{
	/**
	 * Used as a shortcut to have all classes in a directory extend.
	 * For example if a class XenPlus_Extend_Model_User existed and this was called with getExtension($className, 'XenPlus_Extend_')
	 * then it would return true when XenForo_Model_User is called, then you could add it to $extend in your listener.
	 * 
	 * @param  string $className 
	 * @param  string $prefix    
	 * @param  string $replace   
	 * @return mixed false if no class, string of new class if it exists
	 */
	public function getExtension($className, $prefix = '', $replace = 'XenForo_')
	{
		$className = $prefix . $className;
		if ($replace)
			$className = str_replace($replace, '', $className);

		$filename = XenForo_Autoloader::getInstance()->autoloaderClassToFile($className);
		return $filename && file_exists($filename) ? $className : false;
	}
}