<?php

abstract class XenPlus_Listener_FrontControllerPreRoute extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_FrontController $fc);
}