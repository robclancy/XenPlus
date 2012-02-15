<?php

abstract class XenPlus_Installer
{
    protected $_db;

    protected $_existingAddon;

    protected $_addonData;

    protected $_rebuildContentCache = false;

    protected static $_modelCache = array();

    public function __construct($existingAddon, $addonData = null)
    {
        $this->_db = XenForo_Application::get('db');
        $this->_existingAddon = $existingAddon;
        $this->_addonData = $addonData;
    }

    public function __destruct()
    {
        if ($this->_rebuildContentCache)
        {
            XenForo_Model::create('XenForo_Model_ContentType')->rebuildContentTypeCache();
        }
    }

    public static function install($existingAddon, $addonData)
    {
		$class = self::_getClass();
        $installer = new $class($existingAddon, $addonData);
        return $installer->runInstall();
    }

    public static function uninstall($existingAddon)
    {
		$class = self::_getClass();
        $installer = new $class($existingAddon);
        return $installer->runUninstall();
    }

	protected static function _getClass()
	{
		if (version_compare(phpversion(), '5.3') != -1)
			return get_called_class();

		$backtrace = debug_backtrace();
		$args = false;
		foreach($backtrace as $key => $trace)
		{
			if ($trace['function'] == 'call_user_func')
			{
				$args = $trace['args'];
				break;
			}
		}

		if (!$args || empty($args[0][0]))
			throw new XenForo_Exception('Failed to make XenPlus compatible with PHP 5.2');

		return $args[0][0];
	}

    public function runInstall()
    {
        $start = 1;

        if ($this->_existingAddon)
            $start += $this->_existingAddon['version_id'];

        $this->_preInstall();

        XenForo_Db::beginTransaction($this->_db);

		try
		{
        	for ($v = $start; $v <= $this->_addonData['version_id']; ++$v)
           		$this->_callVersionMethod($v);
		}
		catch (Exception $e)
		{
			XenForo_Db::rollback($this->_db);
			throw $e;
		}

        XenForo_Db::commit($this->_db);

        $this->_postInstall();

        return true;
    }

    public function runUninstall()
    {
        XenForo_Db::beginTransaction($this->_db);

		try
		{
			for ($v = $this->_existingAddon['version_id']; $v >= 0; --$v)
				$this->_callVersionMethod($v, true);
		}
		catch (Exception $e)
		{
			XenForo_Db::rollback($this->_db);
			throw $e;
		}

        XenForo_Db::commit($this->_db);

        return true;
    }

    protected function _preInstall()
    {

    }

    protected function _postInstall()
    {

    }

    protected function _callVersionMethod($version, $uninstall = false)
    {
        if (method_exists($this, '_' . ($uninstall ? 'un' : '') . 'installVersion' . $version))
            $this->{'_' . ($uninstall ? 'un' : '') . 'installVersion' . $version}();
    }

    protected function _bulkAddContentType(array $types)
    {
        if (!is_array($types))
            return;

        foreach ($types as $type => $pairs)
        {
            if (!is_array($pairs))
                continue;

            foreach ($pairs as $name => $value)
                $this->_addContentType($type, $name, $value);
        }
    }

    protected function _addContentType($type, $name, $value)
    {
        $this->_rebuildContentCache = true;

        if (!$this->_db->fetchRow('SELECT * FROM xf_content_type_field WHERE content_type = ? AND field_name = ?', array($type, $name)))
            $this->_db->insert('xf_content_type_field', array(
				'content_type' => $type,
				'field_name' => $name,
				'field_value' => $value)
			);

        if (!$this->_db->fetchRow('SELECT * FROM xf_content_type WHERE content_type = ?', $type))
            $this->_db->insert('xf_content_type', array('content_type' => $type, 'addon_id' => $this->_addonData['addon_id'], 'fields' => ''));
    }

    protected function _removeContentType($type, $name = null)
    {
        $this->_rebuildContentCache = true;

        $handlers = array(
            'alert_handler_class' => 'xf_user_alert',
            'news_feed_handler_class' => 'xf_news_feed',
            'report_handler_class' => array('xf_report', '_removeReportComments'),
            // TODO: add the rest of the possible handlers
        );

        $single = false;
        if ($name && isset($handlers[$name]))
            $single = $handlers[$name];
        else
            return;//$name = '*';

        $this->_db->delete('xf_content_type', 'content_type = ' . $this->_db->quote($type));
        $this->_db->delete('xf_content_type_field', 'content_type = ' . $this->_db->quote($type) . ' AND field_name = ' . $this->_db->quote($name));

        if ($single)
        {
            if (is_array($single))
            {
                if (method_exists($this, $single[1]))
                    $this->$single[1]($type);

                $single = $single[0];
            }

            $this->_db->delete($single, array('content_type = ?' => $type));
            return;
        }

        foreach ($handlers as $handle)
        {
            if (is_array($handle))
            {
                if (method_exists($this, $handle[1]))
                    $this->$handle[1]($type);

                $handle = $handle[0];
            }

            $this->_db->delete($handle, array('content_type = ?' => $type));
        }
    }

    protected function _removeReportComments($type)
    {
        $reportIds = $this->_db->fetchCol('SELECT report_id FROM xf_report WHERE content_type = ?', $type);
        if (!empty($reportIds))
            $this->_db->delete('xf_report_comment', array('report_id IN (' . implode(',', $reportIds) . ')'));
    }

    protected function _addTableColumn($table, $field, $info, $after = '', $overwriteIfExists = false)
    {
        $columns = $this->_db->describeTable($table);

		$action = 'ADD';
        if (isset($columns[$field]))
		{
			if (!$overwriteIfExists)
				return;

			$action = "CHANGE `$field`";
		}

        if (isset($columns[$after]) && !isset($columns[$field]))
            $info .= ' AFTER ' . $after;

        $this->_db->query("ALTER TABLE `$table` $action `$field` $info");
    }

	protected function _addValueToColumnEnum($table, $column, $values)
	{
		$field = $this->_db->fetchRow('
			SELECT *
			FROM information_schema.columns
			WHERE table_name = ? AND column_name = ?'
		, array($table, $column));

		if (!$field || strpos($field['COLUMN_TYPE'], 'enum(') !== 0)
			return;

		if (!is_array($values))
			$values = array($values);

		$originalValues = explode("','", substr($field['COLUMN_TYPE'], 6, strlen($field['COLUMN_TYPE']) - 8));
		foreach ($values as $k => $value)
			if (in_array($value, $originalValues))
				unset($values[$k]);

		if (empty($values))
			return;

		$enum = "enum('" . implode("','", array_merge($originalValues, $values)) . "')";
		$info = $enum . ' CHARACTER SET ' . $field['CHARACTER_SET_NAME'] . ' COLLATE ' . $field['COLLATION_NAME'] . ' DEFAULT \'' . $field['COLUMN_DEFAULT'] . '\' ' . ($field['IS_NULLABLE'] == 'YES' ? 'NULL' : 'NOT NULL');
		$this->_addTableColumn($table, $column, $info, '', true);
	}

	protected function _removeValueFromColumnEnum($table, $column, $values)
	{
		$field = $this->_db->fetchRow('
			SELECT *
			FROM information_schema.columns
			WHERE table_name = ? AND column_name = ?'
		, array($table, $column));

		if (!$field || strpos($field['COLUMN_TYPE'], 'enum(') !== 0)
			return;

		if (!is_array($values))
			$values = array($values);

		$enum = explode("','", substr($field['COLUMN_TYPE'], 6, strlen($field['COLUMN_TYPE']) - 8));
		foreach ($enum as $k => $e)
			if (in_array($e, $values))
				unset($enum[$k]);

		$enum = "enum('" . implode("','", $enum) . "')";
		$info = $enum . ' CHARACTER SET ' . $field['CHARACTER_SET_NAME'] . ' COLLATE ' . $field['COLLATION_NAME'] . ' DEFAULT \'' . $field['COLUMN_DEFAULT'] . '\' ' . ($field['IS_NULLABLE'] == 'YES' ? 'NULL' : 'NOT NULL');
		$this->_addTableColumn($table, $column, $info, '', true);
	}

    protected function _removeTableColumn($table, $field)
    {
        $columns = $this->_db->describeTable($table);

        if (isset($columns[$field]))
        {
            $this->_db->query("ALTER TABLE $table DROP COLUMN $field");
        }
    }

    protected function _getModelFromCache($class)
	{
		if (!isset(self::$_modelCache[$class]))
		{
			self::$_modelCache[$class] = XenForo_Model::create($class);
		}

		return self::$_modelCache[$class];
	}


}