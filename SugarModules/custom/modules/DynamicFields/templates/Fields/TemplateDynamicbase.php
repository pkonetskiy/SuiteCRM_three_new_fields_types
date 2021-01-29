<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class CustomTemplateDynamicbase extends TemplateField
{
    public $type='dynamicbase';
    public $len = '';

    public function __construct()
    {
        parent::__construct();
        $this->vardef_map['popupHelp'] = 'help';
        $this->vardef_map['studio'] = 'ext1';
        $this->popupHelp='';
        $this->inline_edit=0;
        $this->ext1=base64_encode(serialize(array('listview'=>false,'searchview'=>false,'quickcreate'=>false,'dashlet'=>false,'detailview'=>true,'editview'=>true,'editField'=>true)));
    }
    public function get_field_def()
    {
        $def = parent::get_field_def();
        $def['dbType'] = 'longtext';
        $def['popupHelp'] = (isset($this->help)) ?  $this->help : '';
        $studio_support=array('saveField','editLayout','modulefields','modulefield');
        $view_support=array('editview','detailview');
        $def['studio']=false;
        if(in_array($_REQUEST['action'],$studio_support,true)&&(in_array($_REQUEST['view'],$view_support,true)||!isset($_REQUEST['view']))){
            $def['studio']=(!empty($this->ext1)) ?  unserialize(base64_decode($this->ext1)) : true;
        }
        return $def;
    }
    public function populateFromPost(){
        parent::populateFromPost();
        $this->studio=unserialize(base64_decode($this->ext1));
    }
}

