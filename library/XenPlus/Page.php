<?php

abstract class XenPlus_Page
{
    protected $_controller;
    protected $_response;
    protected $_db;

    public function __construct(XenForo_ControllerPublic_Abstract $controller, XenForo_ControllerResponse_Abstract &$response)
    {
        $this->_db = XenForo_Application::get('db');
        $this->_controller = $controller;
        $this->_response = $response;
    }

    public static function page(XenForo_ControllerPublic_Abstract $controller, XenForo_ControllerResponse_Abstract &$response)
    {
        $page = new static($controller, $response);
        return $page->execute();
    }

    abstract public function execute();
}