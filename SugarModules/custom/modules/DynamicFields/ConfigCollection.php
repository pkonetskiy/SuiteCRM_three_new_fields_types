<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

class ConfigCollection {
    const lengthFixedPartFieldName=36;
    public $relationships;
    public $definition;
    public $currentModule;
    public $workModules=array();

    public function __construct($collectionModule='',$currentModule='',$relationship_name='') {
        $this->namePrefix='collection_';
        // use in studio only
        $this->nameSufix='_c';
        $this->collectionModule=$collectionModule;
        $this->includeTypes=array('varchar','name','enum','relate','date','text','int','float','bool','link_file');
        $this->excludeFields=array('assigned_user_id','assigned_user_name','deleted','created_by_name','modified_by_name');
        $this->currentModule=$currentModule;
        if ($relationship_name===''){
            $full_link=$this->collectionModule.'_'.$this->currentModule;
            if(strlen($full_link)>=self::lengthFixedPartFieldName){
                $full_link_md5=md5($full_link);
                $full_link=$this->collectionModule.'_'.$full_link_md5.$full_link_md5.'_'.$this->currentModule;
                $full_link=DBManagerFactory::getInstance()->getValidDBName($full_link, true);
            }
            $relationship_name=mb_strtolower($full_link.'_autolink',"UTF-8");
        }
        if(!empty($currentModule)&&!empty($collectionModule)){
            $this->definition=array(
                'lhs_label' => $this->collectionModule,
                'rhs_label' => $this->currentModule,
                'lhs_subpanel' => '',
                'rhs_subpanel' => '',
                'lhs_module' => $this->collectionModule,
                'rhs_module' => $this->currentModule,
                'relationship_type' => 'many-to-many',
                'relationship_name'=>$relationship_name
            );
        }
//        $GLOBALS['log']->fatal(get_class()." ". __FUNCTION__." this:\n ".print_r($this,true));
    }
    public function getModuleList(){
        $moduleExclude=array('Home',$this->currentModule);
        global $app_list_strings,$moduleList;
        foreach ($app_list_strings['moduleList'] as $module => $name) {
            if(in_array($module, $moduleList) && !in_array($module, $moduleExclude)){
                $this->workModules[$module]=$name;
            }
        }
    }
    public function makeNameRelationship() {
        require_once 'modules/ModuleBuilder/parsers/relationships/ManyToManyRelationship.php';
        $this->newRelationship = new ManyToManyRelationship($this->definition);
        $this->relationships = new DeployedCollectionRelationship($this->currentModule);
        $namesIN=$this->relationships->getRelationshipList();
        $this->relationships->add($this->newRelationship);
        $namesOUT=$this->relationships->getRelationshipList();
        return array_shift(array_diff($namesOUT,$namesIN));
    }
    public function buildNewRelationship($relationship_name){
        $this->relationships->save();
        if (ini_get('opcache.enable')){ini_set('opcache.enable',false);}
        $this->relationships->build('custom/Extension/modules','custom/Extension/modules',$this->relationships);
     }
     
    public function getFieldsNameCollection(){
        $collectionObj=BeanFactory::newBean($this->collectionModule);
        $collectionFields=array('');
        foreach ($collectionObj->field_name_map as $field_name=>$field_params) {
            if(in_array($field_params['type'],$this->includeTypes)&&
                    !in_array($field_name,$this->excludeFields)){
                $collectionFields[$field_name]=$field_name;
            }
        }
        return array('bean_name'=>$collectionObj->object_name,'fields'=>$collectionFields);
    }
    public function deleteRelationship($relationship_name){
        $this->relationships = new DeployedCollectionRelationship($this->currentModule);
        if (ini_get('opcache.enable')){ini_set('opcache.enable',false);}
        $GLOBALS['mi_remove_tables']=true;
        $this->relationships->delete($relationship_name);
    }
}

require_once 'modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php';

class DeployedCollectionRelationship extends DeployedRelationships {
    public static $methods = array(
        'RelationshipMetaData' => 'relationships' ,
        'Vardefs' => 'vardefs' ,
    );
    public function build($basepath = null, $installDefPrefix = null, $relationships = null){
        $installDefs = array( ) ;
        foreach (self::$methods as $method => $key) {
            $buildMethod = 'build' . $method ;
            $saveMethod = 'save' . $method ;
            foreach ($relationships->relationships as $name => $relationship) {
                if (! ($relationship->readonly() || $relationship->deleted())) {
                    if (method_exists($relationship, $buildMethod) && method_exists($this, $saveMethod)) {
                        $metadata = $relationship->$buildMethod() ;
                        if (count($metadata) > 0) {
                            $installDef = $this->$saveMethod($basepath.'/relationships', $installDefPrefix, $name, $metadata) ;
                            if (! is_null($installDef)) {
                                foreach ($installDef as $moduleName => $def) {
                                    $installDefs [$key] [ ] = $def ;
                                }
                            }
                        }
                    }
                }
            }
        }
        $relationship->setReadonly() ;
        $this->relationships [ $name ] = $relationship ;

        require_once 'ModuleInstall/ModuleInstaller.php' ;
        $mi = new ModuleInstaller() ;

        $mi->id_name = 'custom' . $name ;
        $mi->installdefs = $installDefs ;
        $mi->base_dir = $basepath ;
        $mi->silent = true ;

        VardefManager::clearVardef() ;

        $mi->install_relationships() ;
        $mi->install_vardefs() ;
    }
    public function delete($rel_name){
        require_once("ModuleInstall/ModuleInstaller.php");
        require_once('modules/Administration/QuickRepairAndRebuild.php') ;
        $mi = new ModuleInstaller();
        $mi->silent = true;
        $mi->id_name = 'custom' . $rel_name;
        $mi->uninstall_relationship("custom/metadata/{$rel_name}MetaData.php");

        Relationship::delete_cache();
        $mi->rebuild_tabledictionary();

        if (isset($this->relationships[$rel_name])) {
            unset($this->relationships[$rel_name]);
        }
    }
}
