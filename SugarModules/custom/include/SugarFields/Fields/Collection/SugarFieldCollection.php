<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldCollection extends SugarFieldBase {
    var $tpl_path;

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        if(!isset($displayParams['collection_field_list'])||empty($displayParams['collection_field_list'])){
            $displayParams['collection_field_list']=$this->displayParams($vardef);
        }
        if(!isset($vardef['relationship'])){
            $vardef=$this->getRelationship($vardef);
        }
        $nolink = array('Users');
        if(in_array($vardef['module'], $nolink)){
                $displayParams['nolink']=true;
        }else{
                $displayParams['nolink']=false;
        }
        $this->getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
        if(empty($this->tpl_path)){
            $this->tpl_path = $this->findTemplate('DetailView');
        }
        return $this->fetch($this->tpl_path);
    }

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, $searchView = false) {
        if($searchView){
            $form_name = 'search_form';
        }else{
            $form_name = 'EditView';
        }
        if(!isset($displayParams['collection_field_list'])||empty($displayParams['collection_field_list'])){
            $displayParams['collection_field_list']=$this->displayParams($vardef);
        }
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." 1 vardef:\n ".print_r($vardef,true));
/* */
        if(!isset($vardef['relationship'])){
            $vardef=$this->getRelationship($vardef);
        }
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." 2 vardef:\n ".print_r($vardef,true));
/* */
        $this->getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
        if(!$searchView) {
            if(empty($this->tpl_path)){
                $this->tpl_path = $this->findTemplate('EditView');
            }
            return $this->fetch($this->tpl_path);
        }
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
            $this->getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex, true);
    }
    /**
     * This should be called when the bean is saved. The bean itself will be passed by reference
     * @param SugarBean bean - the bean performing the save
     * @param array params - an array of paramester relevant to the save, most likely will be $_REQUEST
     */
    public function save(&$bean, $params, $field, $properties, $prefix = ''){
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." _REQUEST:\n ".print_r($_REQUEST,true));
/* */
        if($bean->field_defs[$field]['type'] == 'collection'){
            $relationship=$bean->field_defs[$field]['relationship_name'];
            foreach ($bean->field_defs as $field_name => $field_params) {
                if($field_params['relationship']==$relationship){
                    $link_field=$field_params['name'];
                }
            }
        }else{
            $link_field = $params[$field];
        }
        if(!empty($link_field) && ($bean->field_defs[$link_field]['type'] == 'link' && $params['action'] != "ConvertLead")){
            $bean->load_relationship($link_field);
            $actual_field_list = Array();
            foreach($params as $name_field=>$value_field){
                $explode_string = '_'.$link_field.'_collection_';
                $new_array = explode($explode_string, $name_field);
                if (count($new_array) == 2){
                    $actual_field_list[$new_array[1]][$new_array[0]] = $value_field;
                }
            }
            $change_list = explode(';', $params['collection_'.$link_field.'_change']);
            $bean_name = $bean->field_defs[$link_field]['bean_name'];
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." actual_field_list:\n ".print_r($actual_field_list,true));
/* */
            foreach($actual_field_list as $key => $value_list){
                if(in_array($key, $change_list)) {
                    $bean_collection = new $bean_name();
                    if (!empty($value_list['id'])) {
                        $bean_collection->retrieve($value_list['id']);
                    }
                    $empty_field = 0;
                    foreach($value_list as $name=>$value){
                        if ($name != 'id') {
                            $bean_collection->$name = $value;
                            if ($bean_collection->$name!==$bean_collection->fetched_row[$name]) {
                                $empty_field += 1;
                            }
                        }
                    }
                    if ($empty_field > 0) {
                        $bean_collection->assigned_user_id = $bean->assigned_user_id;
                        $bean_collection->save();
                        if (empty($bean->id)){
                            $bean->id = create_guid();
                            $bean->new_with_id=true;
                        }
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." bean_collection->id:\n ".print_r($bean_collection->id,true));
/* */
                        $bean->{$link_field}->add($bean_collection);
                    }
                }
            }
            $delete_id_list = explode(';', $params['collection_'.$link_field.'_remove']);
/* BizForce */
//$GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." delete_id_list:\n ".print_r($delete_id_list,true));
/* */
            foreach ($delete_id_list as $delete_id) {
                if (!empty($delete_id)){
                    $bean_collection = new $bean_name();
                    $bean_collection->retrieve($delete_id);
                    $bean_collection->mark_deleted($delete_id);
                }
            }
        }
    }
    protected function getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex){
        $json = getJSONobj();
        $displayParamsJSON = json_encode($displayParams, JSON_HEX_APOS);
        $vardefJSON = $json->encode($vardef);
        $this->ss->assign('displayParamsJSON', '{literal}'.$displayParamsJSON.'{/literal}');
        $this->ss->assign('vardefJSON', '{literal}'.$vardefJSON.'{/literal}');
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
    protected function getRelationship($vardef){
        $bean= BeanFactory::newBean($_REQUEST['module']);
        foreach ($bean->field_name_map as $field_name=>$field_params) {
            if($field_params['relationship']===$vardef['relationship_name']){
                return $bean->getFieldDefinition($field_name);
            }
        }
        return $vardef;
    }
    protected function displayParams($vardef){
        $nn=0;
        $collection=array();
        $collectionBean= BeanFactory::newBean($vardef['collection_module']['name']);
        foreach ($vardef['collection_module']['fields_list'] as $field => $size) {
            $collection[$nn]=array(
                'name'=>$field,
                'displayParams'=>array(
                    'size'=>$size.'%'
                )
            );
            if($collectionBean->field_name_map[$field]['type']==='relate'&&!empty($collectionBean->field_name_map[$field]['id_name'])){
                $collection[$nn]['field_to_name_array']=array(
                    'name'=>$field,
                    'id'=>$collectionBean->field_name_map[$field]['id_name']
                );
            }
            $nn++;
        }
        return $collection;
    }
}
?>