<?php

class XenPlus_Helper_Listener
{
    public static function convertToCamelCase($in, $firstLetterUpper = false)
    {
        // Assumed that this way was slower
        //return $string[0] . str_replace(' ', '', ucwords(str_replace('_', ' ', substr($string, 1))));

        if (empty($in))
            return '';

        $out = $in[0];
        $capitalize = false;
        for ($i  = 1, $len = strlen($in); $i < $len; ++$i)
        {
            if ($in[$i] == '_')
            {
                $capitalize = true;
                continue;
            }

            $out .= $capitalize ? strtoupper($in[$i]) : $in[$i];
            $capitalize = false;
        }

		if ($firstLetterUpper)
			$out[0] = strtoupper($out[0]);

        return $out;
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