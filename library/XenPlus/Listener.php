<?php

/**
 * Base class for listeners. This class simply provides helper
 * methods for common actions.
 *
 * @package XenPlus_Listener
 */
abstract class XenPlus_Listener extends XenPlus_Abstract
{
	/**
	* Constructor. Generally shouldn't be used.
	*/	
	public function __construct()
	{
	}

	/**
	 * Creates the specified helper class. If no underscore is present in the class
	 * name, "XenPlus_Listener_Helper_" is prefixed. Otherwise, a full class name
	 * is assumed.
	 *
	 * @param string $class Full class name, or partial suffix (if no underscore)
	 *
	 * @return XenPlus_Listener_Helper_Abstract
	 */
	public function getHelper($class)
	{
		if (strpos($class, '_') === false)
		{
			$class = 'XenPlus_Listener_Helper_' . $class;
		}

		return new $class($this);
	}

	/**
	 * Designed to be called as the callback from a code event. Will create a new object and call run()
	 * 
	 * @param  mixed &$arg1 
	 * @param  mixed &$arg2 
	 * @param  mixed &$arg3 
	 * @param  mixed &$arg4 
	 * @param  mixed &$arg5 
	 * @param  mixed &$arg6 
	 * @return bool returns run() which should return a bool, false will stop other listeners from running
	 */
	public static function listen($arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null, $arg5 = null, $arg6 = null)
    {
		$class = self::_getClass();
		$listener = new $class;

		if (!method_exists($listener, 'run'))
			throw new XenForo_Exception('Listener doesn\'t have a \'run\' method.');

        return $listener->run($arg1, $arg2, $arg3, $arg4, $arg5, $arg6);
    }

	/**
	 * Method used to hack around the lack of late static binding in PHP < 5.3
	 * 
	 * @return string class name, used by listen() to create a new instance of static::
	 */
	protected static function _getClass()
	{
		if (version_compare(phpversion(), '5.3') != -1)
			return get_called_class();

		$backtrace = debug_backtrace();
		$args = false;
		foreach($backtrace as $key => $trace)
		{
			if ($trace['function'] == 'call_user_func_array')
			{
				$args = $trace['args'];
				break;
			}
		}

		if (!$args || empty($args[0][0]))
			throw new XenForo_Exception('Failed to make XenPlus compatible with PHP 5.2');

		return $args[0][0];
	}
}