<?php

abstract class XenPlus_Listener_VisitorSetup extends XenPlus_Listener_Abstract
{
    abstract public function execute(XenForo_Visitor &$visitor);
}