<?php

abstract class XenPlus_Listener_LoadClass extends XenPlus_Listener_Abstract
{
	protected $_class = null;

    public function execute($class, array &$extend)
    {
		$this->_class = $class;

        if (method_exists($this, '_extend'))
        {
            $classes = $this->_extend();

            foreach ($classes as $clas)
            {
                if (!is_array($clas))
                    $clas = array($clas);

                if (empty($clas[1]) || $clas[1] == $class)
                    $extend[] = $clas[0];

            }
        }

        $method = '_loading' . str_replace('_', '', ucfirst($class));
        if (method_exists($this, $method))
            $this->$method($extend);
    }
}