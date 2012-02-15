<?php

require_once 'XenPlus/Helper/Listener.php';

class XenPlus_Helper_ListenerTest extends PHPUnit_Framework_TestCase
{
	public function testConvertToCamelCase()
	{
		$this->assertEquals(XenPlus_Helper_Listener::convertToCamelCase('first_test_string'), 'firstTestString');

		$this->assertEquals(XenPlus_Helper_Listener::convertToCamelCase('_second_test_string'), 'secondTestString');

		$this->assertEquals(XenPlus_Helper_Listener::convertToCamelCase('third_test_string', true), 'ThirdTestString');

		$this->assertEquals(XenPlus_Helper_Listener::convertToCamelCase('_fourth_test_string', true), 'FourthTestString');
	}
}