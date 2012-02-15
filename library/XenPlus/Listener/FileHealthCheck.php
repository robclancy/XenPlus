<?php

abstract class XenPlus_Listener_FileHealthCheck extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_ControllerAdmin_Abstract $controller, array &$hashes);
}