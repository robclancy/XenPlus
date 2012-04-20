<?php

/**
 * @package XenPlus_Autoloader
 */
class XenPlus_Autoloader_ExtendAnyClass extends XenPlus_Autoloader_Abstract
{
	protected static $_classCache = array();

	public static function extendClass($class, $extend)
	{
		self::$_classCache[$class][] = $extend;
	}

	public function autoload($class)
	{
		if (class_exists($class, false) || interface_exists($class, false))
		{
			return true;
		}

		if ($class == 'utf8_entity_decoder')
		{
			return true;
		}

		if (substr($class, 0, 5) == 'XFCP_')
		{
			throw new XenForo_Exception('Cannot load class using XFCP. Load the class using the correct loader first.');
		}

		$filename = $this->autoloaderClassToFile($class);
		if ($filename && file_exists($filename))
		{
			if (isset(self::$_classCache[$class]))
			{
				$fakeBase = 'XFCP_FB_' . $class;
				$baseClassFile = file_get_contents($filename);
				if (strpos($baseClassFile, 'class ' . $class) !== false)
					$baseClassFile = str_replace('class ' . $class, 'class ' . $fakeBase, $baseClassFile);
				elseif (strpos($baseClassFile, 'interface ' . $class) !== false)
					$baseClassFile = str_replace('interface ' . $class, 'interface ' . $fakeBase, $baseClassFile);
				else
					throw new XenForo_Exception('Failed to load class.');

				eval(trim($baseClassFile, '<?php'));

				$createClass = $fakeBase;
				foreach (self::$_classCache[$class] as $dynamicClass)
				{
					$proxyClass = 'XFCP_' . $dynamicClass;
					eval('class ' . $proxyClass . ' extends ' . $createClass . ' {}');
					if ($this->autoloaderClassToFile($dynamicClass))
					{
						$createClass = $dynamicClass;
					}
				}

				eval('class ' . $class . ' extends ' . $createClass . '{}');

				return (class_exists($class, false) || interface_exists($class, false));
			}
		}

		return parent::autoload($class);
	}

	public static function getExtendedInstance()
	{
		return new self;
	}
}