<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('custom/include/SugarFields/Fields/Dynamicbase/ViewSugarFieldDynamicbase.php');
$view = new ViewSugarFieldDynamicbase();
$view->getValues();
echo $view->display();
