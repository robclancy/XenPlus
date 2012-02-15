<?php

abstract class XenPlus_Listener_InitDependencies extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_Dependencies_Abstract $dependencies, array $data);
}