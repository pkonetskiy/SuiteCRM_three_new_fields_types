<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
function get_body(&$ss, $vardef)
{
    $collection=array();
    $numberFields=7;
    $collection['size']=array('',5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,55=>55,60=>60,65=>65,70=>70,75=>75,80=>80,85=>85,90=>90);
    $collection['max_size']=end($collection['size']);
    $support=true;
    if(!empty($_REQUEST['view_package']) && $_REQUEST['action']==='modulefield' && $_REQUEST['module']=='ModuleBuilder'){
        $support=false;
    }
    $collectionModule='';
    if(isset($_REQUEST['collectionModule'])&&!empty($_REQUEST['collectionModule'])){
        $collectionModule=$_REQUEST['collectionModule'];
    }else{
        if(isset($vardef['collection_module']['name'])){
            $collectionModule=$vardef['collection_module']['name'];
        }
    }
    require_once 'custom/modules/DynamicFields/ConfigCollection.php';
    $makeRelationship= new ConfigCollection($collectionModule,$_REQUEST['view_module']);
    $makeRelationship->getModuleList();
    if(!empty($collectionModule)){
        if(isset($vardef['relationship_name'])&&!empty($vardef['relationship_name'])){
            $name=$vardef['relationship_name'];
        }else{
            $name=$makeRelationship->makeNameRelationship();
        }
        global $app_list_strings;
        $makeRelationship->workModules=array();
        $makeRelationship->workModules[$collectionModule]=$app_list_strings['moduleList'][$collectionModule];
        $obj=$makeRelationship->getFieldsNameCollection();
        $collection['fieldName']=$vardef['type'].'_'.$name;
        $collection['fields']=$obj['fields'];
        $collection['module']=$collectionModule;
        $collection['relationship_name']=$name;
        if(is_array($vardef['collection_module']['fields_list'])){
            $collection['selections']=$vardef['collection_module']['fields_list'];
        }
        $json = getJSONobj();
        $jsonCollection = $json->encode($collection);
        $ss->assign('jsonCollection',$jsonCollection);
        $ss->assign('collection', $collection);
        $ss->assign('numberFields', $numberFields);
    }
    $ss->assign('workModules', $makeRelationship->workModules);
    $scriptfield='custom/modules/DynamicFields/templates/Fields/Forms/collection.js';
    $ss->assign('scriptfield',$scriptfield);
    $ss->assign('support', $support);
    return $ss->fetch('custom/modules/DynamicFields/templates/Fields/Forms/collection.tpl');
}
