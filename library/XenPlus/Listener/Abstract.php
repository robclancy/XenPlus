<?php

abstract class XenPlus_Listener_Abstract
{
    protected $_db;
    protected $_options;
    protected $_modelCache = array();

    public function __construct()
    {
        $this->_db = XenForo_Application::get('db');
        $this->_options = XenForo_Application::get('options');
    }

    // Hacky but the best way I could think of doing it
    public static function listen($arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null,
        $arg5 = null, $arg6 = null, $arg7 = null, $arg8 = null, $arg9 = null, $arg10 = null)
    {
		$class = self::_getClass();
		$listener = new $class;
        $listener->execute($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9, $arg10);
    }

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
    
    protected function _getModelFromCache($class)
	{
		if (!isset($this->_modelCache[$class]))
		{
			$this->_modelCache[$class] = XenForo_Model::create($class);
		}

		return $this->_modelCache[$class];
	}
}