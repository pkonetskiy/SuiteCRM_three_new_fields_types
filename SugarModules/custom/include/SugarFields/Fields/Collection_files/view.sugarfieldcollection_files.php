<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('custom/include/SugarFields/Fields/Collection_files/ViewSugarFieldCollection_files.php');
$view = new ViewSugarFieldCollection_files();
$view->setup();
$view->process();
$view->init_tpl();
echo $view->display();
?>