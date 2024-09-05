<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
// unset($js_groupings[$sugar_field_grp]['include/SugarFields/Fields/Collection/SugarFieldCollection.js']);
// $js_groupings = array(
//        $sugar_field_grp = array(
//        'custom/include/SugarFields/Fields/Collection/SugarFieldCollection.js' => 'include/javascript/sugar_field_grp.js',
//        'custom/include/SugarFields/Fields/Collection_files/SugarFieldCollection_files.js' => 'include/javascript/sugar_field_grp.js',
//        'include/SugarFields/Fields/Datetimecombo/Datetimecombo.js' => 'include/javascript/sugar_field_grp.js',
//    ),
// );

// Remove old SugarFieldCollection add new elements to sugar_field_grp.js
for($i=0; $i < count($js_groupings); $i++){
    if (isset($js_groupings[$i]['include/SugarFields/Fields/Collection/SugarFieldCollection.js'])){
        unset($js_groupings[$i]['include/SugarFields/Fields/Collection/SugarFieldCollection.js']);
        $js_groupings[$i]['custom/include/SugarFields/Fields/Collection/SugarFieldCollection.js'] = 'include/javascript/sugar_field_grp.js';
        $js_groupings[$i]['custom/include/SugarFields/Fields/Collection_files/SugarFieldCollection_files.js'] = 'include/javascript/sugar_field_grp.js';
        break;
    }
}
