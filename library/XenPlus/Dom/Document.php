<?php



/**
 * This class is created to fix the following issues with DOMDocument.
 * - Fixes an issue with chartsets when loading HTML or XML
 * - Stops the output of head information on saveHTML
 *
 * @package XenPlus
 */
class XenPlus_Dom_Document extends DOMDocument
{
	/**
	 * Load HTML from a string
	 *
	 * @param string $source <p>
	 * The HTML string.
	 * </p>
	 *
	 * @return bool
	*/
	public function loadHTML($source)
	{
		$source = mb_convert_encoding($source, 'HTML-ENTITIES', $this->getEncoding());
		return parent::loadHTML($source);
	}

	/**
	 * Load XML from a string
	 *
	 * @param string $source <p>
	 * The string containing the XML.
	 * </p>
	 * @param int $options [optional] <p>
	 * Bitwise OR
	 * of the libxml option constants.
	 * </p>
	 *
	 * @return bool
	*/
	public function loadXML($source, $options = null)
	{
		$source = mb_convert_encoding($source, 'HTML-ENTITIES', $this->getEncoding());
		return parent::loadXML($source, $options);
	}

	/**
	 * Dumps the internal document into a string using HTML formatting
	 *
	 * @return string the HTML, or false if an error occurred.
	 */
	public function saveHTML()
	{
   		return preg_replace(array('/^\<\!DOCTYPE.*?<html><body>/si', '!</body></html>$!si'), "", parent::saveHTML());
	}
}