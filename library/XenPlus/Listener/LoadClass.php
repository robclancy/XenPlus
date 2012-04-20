<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_LoadClass 
{
    /**
     * This event can be used to extend the class that will be instantiated dynamically.
     * 
     * To use this event properly, determine if the class is one you want to extend. 
     * If so, add a new entry to $extend with the name of the class that should extend it. 
     * This class MUST be defined as follows:
     * 
     * class My_Class_Name extends XFCP_My_Class_Name
     * {
     *     // functionality to extend/override
     * }
     * This class must extend the non-existent XFCP_x class. This will be resolved at run time.
     * 
     * @param string $class   - the name of the class to be created
     * @param array  &$extend - a modifiable list of classes that wish to extend the class. See above.
     * 
     * @return bool - return false to stop running other listeners
     */
    public function run($class, array &$extend);
}

/*
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
}*/