<?php

interface XenPlus_Listener_ContainerPublicParams
{
	/**
	 * Called while preparing the container template of public/front-end pages (PAGE_CONTAINER). 
	 * You should use this to fetch any data you need for the container.
	 * 
	 * @param array &$params 	   - an array of key-value params that will be available in the container. 
	 *                               You may modify existing ones or add your own values here.
	 * 
	 * @param XenForo_Dependencies_Abstract $dependencies - the dependencies object that triggered this event. 
	 *                                                     	 You will generally not need to use this.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(array &$params, XenForo_Dependencies_Abstract $dependencies);
}