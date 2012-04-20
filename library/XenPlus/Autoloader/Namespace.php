<?php

/**
 * XenPlus_Autoloader
 */
class XenPlus_Autoloader_Namespace extends XPCP_XenPlus_Autoloader_Abstract
{
	/**
	 * This extends the Zend_Type_Autoloading and adds in Namespace\Style\Autoloading
	 * @param  string $class
	 * @return mixed        
	 */
	public function autoloaderClassToFile($class)
	{
		if (file_exists($filePath = parent::autoloaderClassToFile($class)))
			return $filePath;

		if (preg_match('#[^a-zA-Z0-9_\\\]#', $class))
		{
			return false;
		}

		return $this->_rootDir . '/' . str_replace('\\', '/', $class) . '.php';
	}

	public static function getExtendedInstance()
	{
		return new self;
	}
}