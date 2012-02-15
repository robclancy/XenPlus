<?php

abstract class XenPlus_Listener_ContainerAdminParams extends XenPlus_Listener_Abstract
{
    abstract public function execute(array &$params, XenForo_Dependencies_Abstract $dependencies);
}