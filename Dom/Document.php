<?php

class XenPlus_Dom_Document extends DOMDocument
{
	public function loadHTML($source)
	{
		$source = mb_convert_encoding($source, 'HTML-ENTITIES', $this->getEncoding());
		return parent::loadHTML($source);
	}

	public function loadXML($source, $options = null)
	{
		$source = mb_convert_encoding($source, 'HTML-ENTITIES', $this->getEncoding());
		return parent::loadXML($source, $options);
	}

	public function saveHTML()
	{
   		return preg_replace(array('/^\<\!DOCTYPE.*?<html><body>/si', '!</body></html>$!si'), "", parent::saveHTML());
	}

	public function getEncoding()
	{
		return $this->encoding === null ? 'UTF-8' : $this->encoding;
	}
}