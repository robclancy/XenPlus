<?php

abstract class XenPlus_Listener_FrontControllerPreView extends XenPlus_Listener_Abstract
{
    abstract public function execute(
        XenForo_FrontController $fc,
        XenForo_ControllerResponse_Abstract &$controllerResponse,
        XenForo_ViewRenderer_Abstract &$viewRenderer,
        array &$containerParams);
}