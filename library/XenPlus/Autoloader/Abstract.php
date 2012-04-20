<?php

// NOTE: these autoloaders are experimental

/**
 * XenPlus_Autoloader
 */
class XenPlus_Autoloader_Abstract extends XenForo_Autoloader
{
	/**
	 * @var boolean
	 */
	protected static $_setupExtension = false;

	protected static $_alreadySetup = array();

	/**
	 * Register the new loader
	 */
	protected function _setupAutoloader()
	{
		parent::_setupAutoloader();

		if ($this->_setupExtension)
			return;

		spl_autoload_register(array($this, 'autoload'));
	}

	/**
	 * Inject the new autoloader instance.
	 */
	public static function extend($className)
	{
		if (!self::$_alreadySetup[$className])
		{
			$lastClass = get_class(self::getInstance());
			$proxy = 'XPCP_' . $className;
			eval('class ' . $proxy . ' extends ' . $lastClass . '{}');
			$instance = $className::getExtendedInstance();
			self::setInstance($instance); // might need to change to XenForo_Autoloader::setInstance
			$instance->setupAutoloader(XenForo_Application::getInstance()->getRootDir() . '/library');
		}
	}
}