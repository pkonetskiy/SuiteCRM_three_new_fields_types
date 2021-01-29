<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class CustomTemplateCollection extends TemplateField
{
    public $type='collection';
    public $len = '';
    public $relationship_name = '';

    public function __construct()
    {
        parent::__construct();
        $this->vardef_map['popupHelp'] = 'help';
        $this->vardef_map['relationship_name'] = 'ext2';
        $this->vardef_map['collection_module'] = 'ext4';
        $this->vardef_map['studio'] = 'ext1';
        $this->popupHelp='';
        $this->inline_edit=0;
        $this->ext1=base64_encode(serialize(array('listview'=>false,'searchview'=>false,'quickcreate'=>false,'dashlet'=>false,'detailview'=>true,'editview'=>true,'editField'=>true)));
    }
    public function get_field_def()
    {
        $def = parent::get_field_def();
        $studio_support=array('saveField','editLayout','modulefields');
        $view_support=array('editview','detailview');
        $def['dbType'] = 'longtext';
        $def['popupHelp'] = (isset($this->help)) ?  $this->help : '';
        $def['studio']=false;
        if((in_array($_REQUEST['action'],$studio_support,true)&&(in_array($_REQUEST['view'],$view_support,true)))||!isset($_REQUEST['view'])){
            $def['studio']=(!empty($this->ext1)) ?  unserialize(base64_decode($this->ext1)) : true;
        }
        if(empty($def['relationship_name'])&&!empty($this->ext2)){
            $def['relationship_name']=$this->ext2;
        }
        if(empty($def['collection_module'])&&!empty($this->ext4)){
            $def['collection_module']=unserialize(base64_decode($this->ext4));
        }
        return $def;
    }
    public function populateFromRow($row){
        parent::populateFromRow($row);
        $this->relationship_name=$row['relationship_name'];
    }
    public function populateFromPost(){
        // add relationship many-to-many
        if(isset($_REQUEST['relationship_name'])&&!empty($_REQUEST['relationship_name'])&&$_REQUEST['is_update']=='false'){
            require_once 'custom/modules/DynamicFields/ConfigCollection.php';
            $makeRelationship= new ConfigCollection($_REQUEST['collection_module'],$_REQUEST['view_module']);
            $name=$makeRelationship->makeNameRelationship();
            if($_REQUEST['relationship_name']!==$name){
                $relationship_name=$name;
            }else{
                $relationship_name=$_REQUEST['relationship_name'];
            }
            $makeRelationship->buildNewRelationship($relationship_name);
        }
        // make fields of collection
        parent::populateFromPost();
        if(isset($_REQUEST['collectionfield'])&&isset($_REQUEST['collectionsize'])){
            $collectionIN=array_combine($_REQUEST['collectionfield'], $_REQUEST['collectionsize']);
            foreach ($collectionIN as $field => $size) {
                if($field!='0'&&$size!='0'){
                    $collectionOUT[$field]=$size;
                }
            }
            $this->ext4=base64_encode(serialize(array('name'=>$_REQUEST['collection_module'],'fields_list'=>$collectionOUT,'relationship_name'=>$relationship_name)));
        }
        if(isset($_REQUEST['relationship_name'])&&!empty($_REQUEST['relationship_name'])&&$_REQUEST['is_update']=='false'){
            $this->name=$this->type.'_'.$relationship_name;
            $this->ext2=$relationship_name;
        }
        $this->studio=unserialize(base64_decode($this->ext1));
    }
    public function delete($df){
        require_once 'custom/modules/DynamicFields/ConfigCollection.php';
        if(isset($_REQUEST['collection_module'])&&!empty($_REQUEST['collection_module'])){
            $makeRelationship= new ConfigCollection($_REQUEST['collection_module'],$_REQUEST['view_module'],$this->ext2);
            $makeRelationship->deleteRelationship($this->ext2);
        }
        parent::delete($df);
    }
}