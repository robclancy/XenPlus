<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_InitDependencies
{
	/**
	 * Called when the dependency manager loads its default data. 
	 * This event is fired on virtually every page and is the first thing you can plug into.
	 * 
	 * @param  XenForo_Dependencies_Abstract $dependencies
	 * @param  array                         $data
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(XenForo_Dependencies_Abstract $dependencies, array $data);
}