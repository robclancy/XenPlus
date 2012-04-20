<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_CriteriaPage
{
	/**
	 * Called while testing a page against various criteria in XenForo_Helper_Criteria::pageMatchesCriteria() for trophies, notices etc.
	 * 
	 * @param  string $rule 		 - text identifying the criteria that should be checked.
	 * @param  array  $data 		 - data defining the conditions of the criteria.
	 * @param  array  $params        - template parameters to use in the criteria checks.
	 * @param  array  $containerData - container template parameters to use in the criteria checks.
	 * @param  bool   &$returnValue  - the event code should set this to true if a criteria check succeeds
	 * 
	 * @return bool - return false to stop running other listeners
	 */
	public function run($rule, array $data, array $params, array $containerData, &$returnValue);
}