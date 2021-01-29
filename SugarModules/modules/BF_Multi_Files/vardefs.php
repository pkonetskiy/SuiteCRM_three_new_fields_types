<?php
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

$dictionary['BF_Multi_Files'] = array(
    'table'=>'bf_multi_files',
    'audited'=>false,
    'duplicate_merge'=>false,
    'fields'=>array (
        'active_date' => array(
            'name' => 'active_date',
            'vname' => 'LBL_DOC_ACTIVE_DATE',
            'type' => 'date',
            'required' => false,
            'importable' => 'required',
            'display_default' => 'now',
        ),
        'filename' => array (
            'required' => false,
            'name' => 'filename',
            'vname' => 'LBL_FILENAME',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
        ),
        'mime_type' => array (
            'required' => false,
            'name' => 'mime_type',
            'vname' => 'LBL_MIME_TYPE',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
        ),
        'link_file' => array (
            'name' => 'link_file',
            'vname' => 'LBL_LINK_FILE',
            'type' => 'link_file',
            'source'=>'non-db',
        ),
        'description' => array(
            'name' => 'description',
            'vname' => 'LBL_DESCRIPTION',
            'type' => 'text',
            'comment' => 'Full text of the note',
            'rows' => 2,
            'cols' => 80,
        ),
    ),
    'relationships'=>array (
    ),
    'optimistic_locking'=>true,
            'unified_search'=>true,
);
if (!class_exists('VardefManager')){
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('BF_Multi_Files','BF_Multi_Files', array('basic','assignable','file'));