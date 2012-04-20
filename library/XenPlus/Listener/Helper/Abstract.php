<?php

/**
 * @package XenPlus_Listener
 */
class XenPlus_Listener_Helper_Abstract extends XenPlus_Abstract
{
	/**
	 * Calling listener.
	 *
	 * @var XenPlus_Listener
	 */
	protected $_listener;

	/**
	 * Constructor. Sets up listener.
	 *
	 * @param XenPlus_Listener $listener
	 */
	public function __construct(XenPlus_Listener $listener)
	{
		$this->_listener = $listener;
		$this->_constructSetup();
	}

	/**
	 * Additional constructor behavior.
	 */
	protected function _constructSetup() {}
}