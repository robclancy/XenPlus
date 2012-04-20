<?php

class XenPlus_Listener_Helper_LoadClassTest extends PHPUnit_Framework_TestCase
{
	protected $_mockListener;
	protected $_mockHelper;

	public function setUp()
	{
		$this->_mockListener = $this->getMock('XenPlus_Listener');
		$this->_mockHelper = $this->getMock('XenPlus_Listener_Helper_LoadClass', array(), array($this->_mockListener));
	}

	public function tearDown()
	{
		unset($this->_mockListener);
		unset($this->_mockHelper);
	}

	public function testGetExtension()
	{
		$this->_mockHelper
			->expects($this->once())
			->method('getExtension')
			->with('Test_Class_Name')
			->will($this->returnValue(false));
	}
}