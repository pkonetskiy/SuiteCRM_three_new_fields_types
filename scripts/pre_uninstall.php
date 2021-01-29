<?php
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
function pre_uninstall(){
    $file_list=array(
        'custom/Extension/application/Ext/JSGroupings/CustomFields.php',
        'custom/Extension/application/Ext/Language/en_us.new_fields_types.php',
        'custom/Extension/application/Ext/Language/ru_RU.new_fields_types.php',
        'custom/Extension/application/Ext/ActionFileMap/collection_files.php',
        'custom/Extension/application/Ext/ActionFileMap/dynamicbase.php',
        'custom/Extension/application/Ext/ActionFileMap/collection.php',
        'custom/Extension/application/Ext/ActionFileMap/linkfiledownload.php',
        'custom/Extension/modules/ModuleBuilder/Ext/Language/ru_RU.customfields.php',
        'custom/Extension/modules/ModuleBuilder/Ext/Language/en_us.customfields.php',
        'custom/Extension/modules/DynamicFields/Ext/Language/ru_RU.customfields.php',
        'custom/Extension/modules/DynamicFields/Ext/Language/en_us.customfields.php',
        'custom/include/SugarFields/Fields/Link_file/DetailView.tpl',
        'custom/include/SugarFields/Fields/Link_file/EditView.tpl',
        'custom/include/SugarFields/Fields/Link_file/linkfiledownload.php',
        'custom/include/SugarFields/Fields/Dynamicbase/SugarFieldDynamicbase.php',
        'custom/include/SugarFields/Fields/Dynamicbase/SugarFieldDynamicbase.js',
        'custom/include/SugarFields/Fields/Dynamicbase/DetailView.tpl',
        'custom/include/SugarFields/Fields/Dynamicbase/ViewSugarFieldDynamicbase.php',
        'custom/include/SugarFields/Fields/Dynamicbase/view.sugarfielddynamicbase.php',
        'custom/include/SugarFields/Fields/Dynamicbase/EditView.tpl',
        'custom/include/SugarFields/Fields/Collection/DetailView.tpl',
        'custom/include/SugarFields/Fields/Collection/view.sugarfieldcollection.php',
        'custom/include/SugarFields/Fields/Collection/SugarFieldCollection.js',
        'custom/include/SugarFields/Fields/Collection/EditView.tpl',
        'custom/include/SugarFields/Fields/Collection/CollectionEditViewRow.tpl',
        'custom/include/SugarFields/Fields/Collection/CollectionDetailViewRow.tpl',
        'custom/include/SugarFields/Fields/Collection/ViewSugarFieldCollection.php',
        'custom/include/SugarFields/Fields/Collection/SugarFieldCollection.php',
        'custom/include/SugarFields/Fields/Collection_files/SugarFieldCollection_files.js',
        'custom/include/SugarFields/Fields/Collection_files/SugarFieldCollection_files.php',
        'custom/include/SugarFields/Fields/Collection_files/DetailView.tpl',
        'custom/include/SugarFields/Fields/Collection_files/Collection_filesEditViewRow.tpl',
        'custom/include/SugarFields/Fields/Collection_files/view.sugarfieldcollection_files.php',
        'custom/include/SugarFields/Fields/Collection_files/EditView.tpl',
        'custom/include/SugarFields/Fields/Collection_files/Collection_filesDetailViewRow.tpl',
        'custom/include/SugarFields/Fields/Collection_files/ViewSugarFieldCollection_files.php',
        'custom/modules/DynamicFields/ConfigCollection.php',
        'custom/modules/DynamicFields/templates/Fields/TemplateCollection_files.php',
        'custom/modules/DynamicFields/templates/Fields/Forms/collection_files.php',
        'custom/modules/DynamicFields/templates/Fields/Forms/dynamicbase.tpl',
        'custom/modules/DynamicFields/templates/Fields/Forms/dynamicbase.php',
        'custom/modules/DynamicFields/templates/Fields/Forms/collection.php',
        'custom/modules/DynamicFields/templates/Fields/Forms/collection_files.js',
        'custom/modules/DynamicFields/templates/Fields/Forms/collection.tpl',
        'custom/modules/DynamicFields/templates/Fields/Forms/collection.js',
        'custom/modules/DynamicFields/templates/Fields/TemplateCollection.php',
        'custom/modules/DynamicFields/templates/Fields/TemplateDynamicbase.php',
    );
    foreach ($file_list as $current_file) {
        unlink($current_file);
    }
    echo nl2br("Files of package deleted\n");
    require_once('modules/Administration/QuickRepairAndRebuild.php');
    $randc = new RepairAndClear();
    $randc->repairAndClearAll(array('rebuildExtensions'), array(translate('LBL_ALL_MODULES')), false, false);
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
    echo nl2br("Javascript files rapaired and rebuild\n");
}
