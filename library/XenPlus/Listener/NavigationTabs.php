<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_NavigationTabs
{
	/**
	 * [execute description]
	 * 
	 * @param  array  &$extraTabs    - you may push additional tabs onto this array. Each tab must be identified 
	 *                               with a unique key (see $selectedTabId) and be an array with the following keys:
	 *                               	title 	 	  - title for the main tab
	 *                                	href 	 	  - link for the root of the tab
	 *                                 	position 	  - currently 'home', 'middle', or 'end'. This controls where the 
	 *                                  			  tab will show up in the navigation.
	 *                                  linksTemplate - the name of the template that contains the links that will be 
	 *                                  			  displayed in the second row. The outer HTML of this template 
	 *                                         		  should be a <ul class="secondaryContent blockLinksList">.
	 * @param  string $selectedTabId - the name of the selected tab. Select your tab if this matches.
	 * 
	 * @return bool - return false to stop running other listeners
	 */
    public function execute(array &$extraTabs, $selectedTabId);
}