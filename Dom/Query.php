<?php

class XenPlus_Dom_Query extends Zend_Dom_Query
{
	protected $_dom = null;
	protected $_domLoaded = false;

	public function getDom()
	{
		if ($this->_dom === null)
			$this->_dom = new XenPlus_Dom_Document('1.0', $this->getEncoding());

		return $this->_dom;
	}

	public function getEncoding()
	{
		if ($this->_encoding === null)
			return 'UTF-8';

		return $this->_encoding;
	}

	public function queryXpath($xpathQuery, $query = null)
		{
			if (null === ($document = $this->getDocument())) {
				require_once 'Zend/Dom/Exception.php';
				throw new Zend_Dom_Exception('Cannot query; no document registered');
			}

			$domDoc = $this->getDom();

			if (!$this->_domLoaded)
			{
				libxml_use_internal_errors(true);
				$type   = $this->getDocumentType();
				switch ($type) {
					case self::DOC_XML:
						$success = $domDoc->loadXML($document);
						break;
					case self::DOC_HTML:
					case self::DOC_XHTML:
					default:
						$success = $domDoc->loadHTML($document);
						break;
				}
				$errors = libxml_get_errors();
				if (!empty($errors)) {
					$this->_documentErrors = $errors;
					libxml_clear_errors();
				}
				libxml_use_internal_errors(false);

				if (!$success) {
					require_once 'Zend/Dom/Exception.php';
					throw new Zend_Dom_Exception(sprintf('Error parsing document (type == %s)', $type));
				}

				$this->_domLoaded = true;
			}

			$nodeList   = $this->_getNodeList($domDoc, $xpathQuery);
			return new Zend_Dom_Query_Result($query, $xpathQuery, $domDoc, $nodeList);
		}

}