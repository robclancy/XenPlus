<?php

abstract class XenPlus_Listener_NavigationTabs extends XenPlus_Listener_Abstract
{
    abstract public function execute(array &$extraTabs, $selectedTabId);

    /*public static function listen(array &$extraTabs, $selectedTabId)
    {
        $listener = new static;
        $listener->execute($extraTabs, $selectedTabId);
    }*/
}