<?php

abstract class XenPlus_Listener_CriteriaUser extends XenPlus_Listener_Abstract
{
	protected $_rule;
	protected $_data = array();
	protected $_user = array();

	public function execute($rule, $data, $user, &$returnValue)
	{
		$this->_rule = $rule;
		$this->_data = $data;
		$this->_user = $user;

		$method = '_rule' . XenPlus_Helper_Listener::convertToCamelCase($rule, true);
		$methodExists = method_exists($this, $method);

		if ($this->_preRule($methodExists) === false)
			return;

		if ($methodExists)
			$returnValue = $this->$method();

		$this->_postRule();
	}

	protected function _preRule(&$ruleExists){ return true; }

	protected function _postRule(){}

}