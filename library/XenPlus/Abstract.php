<?php

/**
 * @package XenPlus
 */
abstract class XenPlus_Abstract 
{
	/**
	* Database object
	*
	* @var Zend_Db_Adapter_Abstract
	*/
	protected $_db = null;

	/**
	 * Standard approach to caching model objects for the lifetime of the model.
	 *
	 * @var array
	 */
	protected $_modelCache = array();

	/**
	 * Gets the specified model object from the cache. If it does not exist,
	 * it will be instantiated.
	 *
	 * @param string $class Name of the class to load
	 *
	 * @return XenForo_Model
	 */
	public function getModelFromCache($class)
	{
		if (!isset($this->_modelCache[$class]))
		{
			$this->_modelCache[$class] = XenForo_Model::create($class);
		}

		return $this->_modelCache[$class];
	}

	/**
	* Helper method to get the database object.
	*
	* @return Zend_Db_Adapter_Abstract
	*/		
	protected function _getDb()
	{
		if ($this->_db === null)
		{
			$this->_db = XenForo_Application::getDb();
		}

		return $this->_db;
	}
}