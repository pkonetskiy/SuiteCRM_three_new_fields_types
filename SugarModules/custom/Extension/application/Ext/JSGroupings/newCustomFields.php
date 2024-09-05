<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

$customScripts = [
    'custom/include/SugarFields/Fields/Collection/SugarFieldCollection.js' => 'include/javascript/sugar_field_grp.js',
    'custom/include/SugarFields/Fields/Collection_files/SugarFieldCollection_files.js' => 'include/javascript/sugar_field_grp.js',
];

foreach ($js_groupings as $keyGroup => $valueGroup) {
    foreach ($valueGroup as $keyElem => $valueElem) {
        if ($keyElem == 'include/SugarFields/Fields/Collection/SugarFieldCollection.js'){
            unset($js_groupings[$keyGroup][$keyElem]);
            $js_groupings[$keyGroup] = array_merge($js_groupings[$keyGroup], $customScripts);
        }
    }
}