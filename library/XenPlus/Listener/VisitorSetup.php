<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_VisitorSetup
{
	/**
	 * Called when the visitor object has been prepared.
	 * 
	 * @param  XenForo_Visitor &$visitor - the visitor instance. From this, you can inspect the user, their permissions, profile fields etc.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function execute(XenForo_Visitor &$visitor);
}