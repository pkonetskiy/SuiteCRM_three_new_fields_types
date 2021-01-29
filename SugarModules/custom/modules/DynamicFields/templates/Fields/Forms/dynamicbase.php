<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

function get_body(&$ss, $vardef)
{
    $support=true;
    if(!empty($_REQUEST['view_package']) && $_REQUEST['action']==='modulefield' && $_REQUEST['module']=='ModuleBuilder'){
        $support=false;
    }
    $ss->assign('support', $support);
    return $ss->fetch('custom/modules/DynamicFields/templates/Fields/Forms/dynamicbase.tpl');
}
/* */
