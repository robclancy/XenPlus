<?php

class XenPlus_Helper_Listener
{
    public static function convertToCamelCase($string, $ucFirst = false)
    {
		$filter = new Zend_Filter_Word_UnderscoreToCamelCase();
		return $ucFirst ? $filter->filter($string) : lcfirst($filter->filter($string));
    }

	public static function insertContent(&$contents, $newContent, $pos, $after = false)
	{
		if (!is_int($pos))
		{
			$newPos = strpos($contents, $pos);
			if ($newPos === false)
				return;

			if ($after)
				$newPos += strlen($pos);
			$pos = $newPos;
		}

		$contents = substr($contents, 0, $pos) . $newContent . substr($contents, $pos);
	}
}