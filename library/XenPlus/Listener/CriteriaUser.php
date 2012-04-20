<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_CriteriaUser
{
	/**
	 * Called while testing a user against user criteria in XenForo_Helper_Criteria::userMatchesCriteria() for trophies, notices etc.
	 * 
	 * @param  string $rule         - text identifying the criteria that should be checked.
	 * @param  array  $data         - data defining the conditions of the criteria.
	 * @param  array  $user         - the user against which to check the criteria.
	 * @param  bool   &$returnValue - the event code should set this to true if a criteria check matches.
	 * 
	 * @return bool - return false to stop running other listeners 
	 */
	public function run($rule, array $data, array $user, &$returnValue);
}