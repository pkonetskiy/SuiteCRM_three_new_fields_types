<?php
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

$dictionary['BF_Dynamicbases'] = array(
    'table'=>'bf_dynamicbases',
    'audited'=>false,
    'duplicate_merge'=>false,
    'fields'=>array (
        'name_field' => array(
            'name' => 'name_field',
            'vname' => 'LBL_NAME_FIELD',
            'type' => 'varchar',
            'required' => false,
            'len' => '64',
            'comment' => '',
        ),
        'parent_type' => array(
            'name' => 'parent_type',
            'vname' => 'LBL_PARENT_TYPE',
            'type' => 'parent_type',
            'dbType' => 'varchar',
            'group' => 'parent_name',
            'required' => false,
            'len' => '255',
            'comment' => '',
            'options' => 'parent_type_display',
        ),
        'parent_name' =>array(
            'name' => 'parent_name',
            'parent_type' => 'record_type_display',
            'type_name' => 'parent_type',
            'id_name' => 'parent_id',
            'vname' => 'LBL_LIST_RELATED_TO',
            'type' => 'parent',
            'group' => 'parent_name',
            'source' => 'non-db',
            'options' => '',
        ),
        'parent_id' =>array(
            'name' => 'parent_id',
            'type' => 'id',
            'group' => 'parent_name',
            'reportable' => false,
            'vname' => 'LBL_PARENT_ID',
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
VardefManager::createVardef('BF_Dynamicbases','BF_Dynamicbases', array('basic','assignable'));