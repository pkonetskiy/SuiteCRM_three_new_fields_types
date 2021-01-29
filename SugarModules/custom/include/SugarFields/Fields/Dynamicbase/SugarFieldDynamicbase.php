<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once 'include/SugarFields/Fields/Base/SugarFieldBase.php';


class SugarFieldDynamicbase extends SugarFieldBase
{
    public function __construct($type)
    {
        if(empty(get_valid_bean_name('BF_Dynamicbases'))){
            $type='Base';
        }else{
            $this->BF_Dynamicbases=new BF_Dynamicbases();
        }
        parent::__construct($type);
    }
    /**
     * @param string $parentFieldArray
     * @param array $vardef
     * @param array $displayParams
     * @param integer $tabindex
     * @return string
     */
    public function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->viewtype = 'DetailView';
        $this->module_dir=$vardef['custom_module'];
        $this->getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('DetailView'));
    }

    /**
     * @param string $parentFieldArray
     * @param array $vardef
     * @param array $displayParams
     * @param integer $tabindex
     * @return string
     */
    public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->viewtype = 'EditView';
        $this->module_dir=$vardef['custom_module'];
        $this->getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('EditView'));
    }
    public function getViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex){
        $json = getJSONobj();
        if(!empty($vardef['value'])){
            $val=unserialize(base64_decode($vardef['value']));
            $vardef['ids']='{literal}'.$json->encode($val).'{/literal}';
        }else{
            $vardef['ids']='';
        }
        $this->ss->assign('viewtype',$this->viewtype);
        $this->ss->assign('vardef',$vardef);
        $scriptfield=getVersionedPath('custom/include/SugarFields/Fields/Dynamicbase/SugarFieldDynamicbase.js');
        $this->ss->assign('scriptfield',$scriptfield);
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
    public function save(&$bean, $params, $field, $properties, $prefix = ''){
        $values_field = $params[$field];
        $ids_field = $params['id_'.$field];
        $remove_fields = json_decode(html_entity_decode($params['remove_list_'.$field.'_dynamicbase']));
        if(!empty($values_field) && !empty($ids_field)&& count($values_field)===count($ids_field) && ($properties['type'] == 'dynamicbase')){
            if(empty($bean->id)){
                $this->saveParentBeanID($bean);
            }
            $actual_ids=$this->saveFields($bean,$ids_field,$values_field,$field,$remove_fields);
            $bean->{$field}= base64_encode(serialize($actual_ids));
        }
        if(!empty($remove_fields)){
            $this->removeFields($remove_fields);
        }
    }
    protected function saveFields($bean,$ids_field,$values_field,$field,$remove_fields) {
        $actual_ids=array();
        foreach ($ids_field as $key=>$id_field) {
            if(!empty($values_field[$key])){
                if(empty($id_field)){
                    $this->BF_Dynamicbases->id=create_guid();
                    $this->BF_Dynamicbases->new_with_id=true;
                }
                else{
                    $this->getRecord($id_field);
                }
                $this->saveRecord($field,$values_field[$key],$bean);
                $actual_ids[]=$this->BF_Dynamicbases->id;
            }else{
                if(!empty($id_field)){
                    array_push($remove_fields,$id_field);
                }
            }
        }
        return $actual_ids;
    }
    protected function getRecord($id_field) {
        $this->BF_Dynamicbases->retrieve($id_field);
    }
    protected function saveRecord($field,$value_field,$bean) {
        $this->BF_Dynamicbases->name=$value_field;
        $this->BF_Dynamicbases->name_field=$field;
        $this->BF_Dynamicbases->parent_type=$bean->module_name;
        $this->BF_Dynamicbases->parent_id=$bean->id;
        $this->BF_Dynamicbases->save();
    }
    protected function removeFields($remove_fields) {
        foreach ($remove_fields as $remove_field) {
            $this->getRecord($remove_field);
            $this->BF_Dynamicbases->mark_deleted($remove_field);
        }
    }
    protected function saveParentBeanID(&$bean) {
        $bean->id = create_guid();
        $bean->new_with_id=true;
    }
}