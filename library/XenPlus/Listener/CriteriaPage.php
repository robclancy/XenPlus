<?php

abstract class XenPlus_Listener_CriteriaPage extends XenPlus_Listener_Abstract
{
	protected $_rule;
	protected $_data = array();
	protected $_params = array();
	protected $_containerData = array();

	public function execute($rule, $data, $params, $containerData, &$returnValue)
	{
		$this->_rule = $rule;
		$this->_data = $data;
		$this->_params = $params;
		$this->_containerData = $containerData;

		$this->testPage($returnValue);
	}

	abstract public function testPage(&$returnValue);
}