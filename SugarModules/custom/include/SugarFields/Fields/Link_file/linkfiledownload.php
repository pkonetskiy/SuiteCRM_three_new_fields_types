<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

global $db;

if((!isset($_REQUEST['isProfile']) && empty($_REQUEST['id'])) || empty($_REQUEST['type']) || !isset($_SESSION['authenticated_user_id'])) {
    die("Not a Valid Entry Point");
}
else {
    $id = explode ( "__" , $_REQUEST['id'], 2  );
    if(is_array($id)){
        $id_name = $id[1];
        $id_id = $id[0];
    }
    require_once("data/BeanFactory.php");
    $file_type=''; // bug 45896
    require_once("data/BeanFactory.php");
    ini_set('zlib.output_compression','Off');//bug 27089, if use gzip here, the Content-Length in header may be incorrect.
    // cn: bug 8753: current_user's preferred export charset not being honored
    $GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id']);
    $GLOBALS['current_language'] = $_SESSION['authenticated_user_language'];
    $app_strings = return_application_language($GLOBALS['current_language']);
    $mod_strings = return_module_language($GLOBALS['current_language'], 'ACL');
    $file_type = strtolower($_REQUEST['type']);
    

    //Custom modules may have capitalizations anywhere in their names. We should check the passed in format first.
    require('include/modules.php');
    $module = $db->quote($_REQUEST['type']);
    if(empty($beanList[$module])) {
        //start guessing at a module name
        $module = ucfirst($file_type);
        if(empty($beanList[$module])) {
            die($app_strings['ERROR_TYPE_NOT_VALID']);
        }
    }
    $bean_name = $beanList[$module];
    if(!file_exists('modules/' . $module . '/' . $bean_name . '.php')) {
        die($app_strings['ERROR_TYPE_NOT_VALID']);
    }

    $focus = BeanFactory::newBean($module);
    $focus->retrieve($id_id);
    if(!$focus->ACLAccess('view')){
        die($mod_strings['LBL_NO_ACCESS']);
    } // if    
    
    
    $download_location = "upload://".$id_id."__".$id_name;
    if(isset($id_id)) {
        header("Content-Type: {$focus->mime_type}");
        header("Content-Length: " . filesize($download_location));
        header("Content-Disposition: attachment; filename=\"".$focus->filename."\";");
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
        set_time_limit(0);
        readfile($download_location);
        die();
    }else {
        die($app_strings['ERR_INVALID_FILE_REFERENCE']);
    }

}
