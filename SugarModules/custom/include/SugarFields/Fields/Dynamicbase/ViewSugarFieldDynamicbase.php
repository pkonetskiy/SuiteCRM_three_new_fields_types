<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

class ViewSugarFieldDynamicbase{
    function __construct() {
        $this->module=$_REQUEST['module'];
        $this->bean_id=$_REQUEST['bean_id'];
        $this->name_field=$_REQUEST['name_field'];
    }
    function getValues(){
        $this->values=array();
        if(!empty($this->bean_id)){
            $beanParent=BeanFactory::newBean($this->module);
            $beanParent->retrieve($this->bean_id);
            if(!empty($beanParent->{$this->name_field})){
                $parentIDS= unserialize(base64_decode($beanParent->{$this->name_field}));
                foreach ($parentIDS as $parentID) {
                    $this->beanDynamicbase= new BF_Dynamicbases();
                    $this->beanDynamicbase->retrieve($parentID);
                    $this->values[$parentID]=$this->beanDynamicbase->name;
                }
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function display(){
        $json=getJSONobj();
        return $json->encode($this->values);
    }
}
