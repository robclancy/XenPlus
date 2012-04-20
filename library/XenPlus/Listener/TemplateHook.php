<?php

/**
 * @package XenPlus_Listener
 */
interface XenPlus_Listener_TemplateHook
{
    /**
     * Called whenever a template hook is encountered (via <xen:hook> tags). You may use this event to 
     * modify the final output of that portion of the template.
     * 
     * A template hook may pass a block of final template output with it; you may either adjust this 
     * text (such as with regular expressions) or add additional output before or after the contents. 
     * Some blocks will not pass contents with them; they are primarily designed to allow you to add 
     * additional components in those positions.
     * 
     * @param  [type]                    $hookName   - the name of the template hook being called.
     * @param  [type]                    &$contents  - the contents of the template hook block. 
     *                                               This content will be the final rendered output of the block. 
     *                                               You should manipulate this, such as by adding additional output at the end.
     * @param  array                     $hookParams - explicit key-value params that have been passed to the hook, enabling 
     *                                               content-aware decisions. These will not be all the params that are available 
     *                                               to the template.
     * @param  XenForo_Template_Abstract $template   - the raw template object that has called this hook. You can access the template 
     *                                               name and full, raw set of parameters via this object.
     * 
     * @return bool - return false to stop running other listeners
     */
    public function run($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template);
}