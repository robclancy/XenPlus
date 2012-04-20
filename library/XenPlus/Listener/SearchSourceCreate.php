<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_SearchSourceCreate
{
	/**
	 * Called when creating the default search source handlers. Search source handlers 
	 * give the opportunity to use an alternative method of searching by overriding a particular class. 
	 * This event gives the option to change the name of the search source handler class that it is 
	 * initialized. Note that this differs from the load_class_* events in approach.
	 * 
	 * @param  string &$class - when called, this contains the name of the search source handler that will be 
	 *                        instantiated. You may overwrite the value of this variable to instantiate a 
	 *                        different class. Note that your class should inherit from XenForo_Search_SourceHandler_Abstract.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function run(&$class);
}