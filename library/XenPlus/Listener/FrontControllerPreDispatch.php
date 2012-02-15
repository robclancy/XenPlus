<?php

abstract class XenPlus_Listener_FrontControllerPreDispatch extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_FrontController $fc, XenForo_RouteMatch &$routeMatch);
}