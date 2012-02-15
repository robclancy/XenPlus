<?php

abstract class XenPlus_Listener_ControllerPreDispatch extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_Controller $controller, $action);
}