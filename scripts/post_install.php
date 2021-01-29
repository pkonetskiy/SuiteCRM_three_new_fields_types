<?php
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
function post_install(){
    echo nl2br("Files of package installed\n");
    ob_start();
    $from = getcwd();
    $_REQUEST['root_directory'] = getcwd();
    require('jssource/minify.php');
    $_REQUEST['js_admin_repair'] = 'replace';
    reverseScripts("$from/jssource/src_files", (string)$from);
    $_REQUEST['js_admin_repair'] = 'concat';
    $_REQUEST['js_rebuild_concat'] = 'rebuild';
    require('jssource/minify.php');
    ob_clean();
    echo nl2br("Javascript rapaired and rebuild\n");
    if (ini_get('opcache.enable')){
        ini_set('opcache.enable',false);
        require_once('modules/Administration/QuickRepairAndRebuild.php');
        $randc = new RepairAndClear();
        $randc->repairAndClearAll(array('repairDatabase'), array('BF_Dynamicbases','BF_Multi_Files'), true, false);
        echo nl2br("DataBase rapaired and rebuild because cache for php files enable\n"); 
    }
}