<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('custom/include/SugarFields/Fields/Collection/SugarFieldCollection.php');

class ViewSugarFieldCollection{
    var $ss; // Sugar Smarty Object
    var $bean;
    var $bean_id;
    var $name;
    var $value_name;
    var $displayParams; // DisplayParams for the collection field (defined in the metadata)
    var $vardef; // vardef of the collection field.
    var $related_module; // module name of the related module
    var $module_dir; // name of the module where the collection field is.
    var $json;
    var $extra_var;
    var $skipModuleQuickSearch = false;
    var $showSelectButton = true;
    var $hideShowHideButton = false;
    var $action_type;
    var $form_name;

    function __construct($fill_data = true){
    	$this->json = getJSONobj();
    	if($fill_data){
                $this->displayParams = json_decode(html_entity_decode($_REQUEST['displayParams']), JSON_HEX_APOS);
	        $this->vardef = $this->json->decode(html_entity_decode($_REQUEST['vardef']));
	        $this->module_dir = $_REQUEST['module_dir'];
	        $this->action_type = $_REQUEST['action_type'];
	        $this->name = $this->vardef['name'];
                $this->relay_id = array();
	        $this->value_name = array();
	        $this->ss = new Sugar_Smarty();
	        $this->extra_var = array();
    	}
    }
    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ViewSugarFieldCollection($fill_data = true){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($fill_data);
    }
    /*
     * Retrieve the related module and load the bean and the relationship
     * call retrieve values()
     */
    function setup(){
        if(!class_exists('Relationship')){

        }

        $rel = new Relationship();
        if(!empty($this->vardef['relationship'])){
        	$rel->retrieve_by_name($this->vardef['relationship']);
        }
        if($rel->relationship_type == 'many-to-many'){
            if($rel->lhs_module == $this->module_dir){
                $this->related_module = $rel->rhs_module;
                $module_dir = $rel->lhs_module;
            }else {
                if($rel->rhs_module == $this->module_dir){
                    $this->related_module = $rel->lhs_module;
                    $module_dir = $rel->rhs_module;
                }else{
                    die("this field has no relationships mapped with this module");
                }
            }
            if($module_dir != $this->module_dir){
                die('These modules do not match : '. $this->module_dir . ' and ' . $module_dir);
            }
            if(isset($GLOBALS['beanList'][$this->module_dir])){
                $class = $GLOBALS['beanList'][$this->module_dir];
                if(file_exists($GLOBALS['beanFiles'][$class])){
                    $this->bean = loadBean($this->module_dir);
                    $this->bean->retrieve($_REQUEST['bean_id']);
                    if($this->bean->load_relationship($this->vardef['name'])){
                        $this->check_id();
                        $this->retrieve_values();
                    }else{
                        die('failed to load the relationship');
                    }
                }else{
                    die('class file do not exist');
                }
            }else{
                die($this->module_dir . ' is not in the beanList.');
            }
        }
        else{
            die("the relationship is not a many-to-many");
        }
    }
    function check_id(){
        $check_id = false;
        foreach ($this->displayParams['collection_field_list'] as $key_field=>$value_field) {
            if ($this->displayParams['collection_field_list'][$key_field]['name'] == 'id')
                $check_id = true;
        }
        if (!$check_id) {
            $this->displayParams['collection_field_list'][$key_field+1]['name'] = 'id';
            $this->displayParams['collection_field_list'][$key_field+1]['displayParams']['hidden'] = true;
        }
    }
    /*
     * Retrieve the values from the DB using the get method of the link class
     * Organize and save the value into the bean
     */
    function retrieve_values(){
        if(!empty($this->vardef) && isset($this->bean->{$this->name})){
            $values = array();
            $values = $this->bean->{$this->name}->get(true);
            $bean_name = $this->vardef['bean_name'];
            $new_bean = new $bean_name();
            $fields_values = Array();
            $k = 0;
            if (!empty($values)) {
                foreach ($values as $key=>$value) {
                    $new_bean->retrieve($value);
                    $field_defs = $new_bean->field_defs;
                    foreach ($this->displayParams['collection_field_list'] as $key_field=>$value_field) {
                         $this->value_name[$k][$value_field['name']] = $new_bean->{$value_field['name']};
                         if($field_defs[$value_field['name']]['type'] == 'relate' && !empty($field_defs[$value_field['name']]['id_name'])){
                             $id_name = $field_defs[$value_field['name']]['id_name'];
                             $this->relay_id[$value_field['name']][$this->value_name[$k][$value_field['name']]] = $new_bean->$id_name;
                         }
                    }
                    if (!isset($this->value_name[$k]['id'])){
                        $this->value_name[$k]['id'] = $value;
                    }
                    $k++;
                }
            } else {
                foreach ($this->displayParams['collection_field_list'] as $key_field=>$value_field) {
                     $this->value_name[0][$value_field['name']] = '';
                }
                if (!isset($this->value_name[0]['id'])){
                    $this->value_name[0]['id'] = '';
                }
            }
        }
    }
    /*
     * redirect to the good process method.
     */
    function process(){
        if($this->action_type == 'editview'){
            $this->viewtype = 'EditView';
            $this->process_editview();
        }else {
            if($this->action_type == 'detailview'){
                $this->viewtype = 'DetailView';
                $this->process_detailview();
            }
        }
    }
    function process_detailview(){
            $this->process_form();
    }
    function process_editview(){
            $this->process_form();
    }
    function process_form(){
        if(isset($this->displayParams['collection_field_list'])){
            $relatedObject = BeanFactory::getObjectName($this->related_module);
            vardefmanager::loadVardef($this->related_module, $relatedObject);
            foreach($this->value_name as $key_value=>$field_value){
                $this->count_values[$key_value] = $key_value;
                foreach($this->displayParams['collection_field_list'] as $k=>$v){
                    $collection_field_vardef = $GLOBALS['dictionary'][$relatedObject]['fields'][$v['name']];
                    foreach($v as $k_override=>$v_override){
                        if($k_override != 'displayParams'){
                            $collection_field_vardef[$k_override] = $v_override;
                        }
                    }
                    $realy_field_name = $collection_field_vardef['name'];
                    $collection_field_vardef['value'] = $field_value[$collection_field_vardef['name']];
                    $collection_field_vardef['name'] .= "_" . $this->vardef['name'] . "_collection_" . $key_value;
                    if(isset($collection_field_vardef['id_name'])){
                        $collection_field_vardef['id_name'] .= "_" . $this->vardef['name'] . "_collection_" . $key_value;
                    }
                    $name = $collection_field_vardef['name'];
                    $this->displayParams['to_display'][$key_value][$name]['vardefName'] = $this->displayParams['collection_field_list'][$k]['name'];
                    $this->displayParams['to_display'][$key_value][$name]['name'] = $name;
                    if($collection_field_vardef['type'] == 'relate'){
                        $this->displayParams['to_display'][$key_value][$name]['id_name'] = $collection_field_vardef['id_name'];
                        $this->displayParams['to_display'][$key_value][$name]['module'] = $collection_field_vardef['module'];
                    }
                    require_once('include/SugarFields/SugarFieldHandler.php');
                    if(!isset($sfh)) {
                        $sfh = new SugarFieldHandler();
                        
                    }
                    if (isset($this->displayParams['collection_field_list'][$k]['customCode']) && !empty($this->displayParams['collection_field_list'][$k]['customCode']) && $this->viewtype != 'DetailView') {
                        $customCode = str_replace($realy_field_name, $realy_field_name.'_'.$this->name.'_collection_'.$key_value.'', $customCode);
                        $this->displayParams['to_display'][$key_value][$name]['field'] = $customCode;
                    } else {
                        if (isset($collection_field_vardef['options']) && !empty($collection_field_vardef['options'])) {
                            $this->displayParams['to_display'][$key_value][$name]['options'] = $GLOBALS['app_list_strings'][$collection_field_vardef['options']];
                        }
                        if ($collection_field_vardef['type'] == 'relate') {
                            if ($this->displayParams['formName'] != 'EditView'){
                                $v['displayParams']['formName'] = $this->displayParams['formName'];
                                $this->displayParams['to_display'][$key_value][$this->displayParams['to_display'][$key_value][$name]['id_name']]['name'] = $this->displayParams['to_display'][$key_value][$name]['id_name'];
                                $this->displayParams['to_display'][$key_value][$this->displayParams['to_display'][$key_value][$name]['id_name']]['hidden'] = 'hidden';
                                $this->displayParams['to_display'][$key_value][$this->displayParams['to_display'][$key_value][$name]['id_name']]['value'] = $this->relay_id[$realy_field_name][$field_value[$realy_field_name]];
                            } else {
                                $this->displayParams['to_display'][$key_value][$this->displayParams['to_display'][$key_value][$name]['id_name']]['hidden'] = 'hidden';
                                $this->displayParams['to_display'][$key_value][$this->displayParams['to_display'][$key_value][$name]['id_name']]['value'] = $this->relay_id[$realy_field_name][$field_value[$realy_field_name]];
                            }
                            if (!empty ($v['displayParams']['field_to_name_array'])){
                                foreach ($v['displayParams']['field_to_name_array'] as $key_field_to_name_array => $value_field_to_name_array) {
                                    $v['displayParams']['field_to_name_array'][$key_field_to_name_array] = $value_field_to_name_array.'_'.$this->name.'_collection_'.$key_value;
                                }
                            }
                        }
                        $this->displayParams['to_display'][$key_value][$name]['value'] = $collection_field_vardef['value'];
                        $this->displayParams['to_display'][$key_value][$name]['field'] = $sfh->displaySmarty('displayParams.to_display.'.$key_value, $collection_field_vardef, $this->viewtype, $v['displayParams'], 1);
                    }
                    if ($this->viewtype == 'EditView') {
                        $this->displayParams['to_display'][$key_value][$name]['field'] .= 
                            '{literal}
                                <script type="text/javascript">'."collection" . $this->vardef['name'] . ".add_change_control('{$collection_field_vardef['name']}');
                                    if(document.getElementById('{$collection_field_vardef['name']}').getAttribute('readonly') == 'readonly'){
                                        document.getElementById('{$collection_field_vardef['name']}').setAttribute('style', 'background: none;');}".'</script>
                            {/literal}';
                        if ($this->displayParams['collection_field_list'][$k]['displayParams']['hidden']) {
                            $this->displayParams['to_display'][$key_value][$name]['field'] .= 
                                '{literal}
                                    <script type="text/javascript">'."document.getElementById('{$collection_field_vardef['name']}').setAttribute('hidden','hidden');".'</script>
                                {/literal}';
                        }
                    }else{
                        if ($this->displayParams['collection_field_list'][$k]['displayParams']['hidden']) {
                            $this->displayParams['to_display'][$key_value][$name]['field'] .= 
                                '{literal}
                                    <script type="text/javascript">'."document.getElementById('{$collection_field_vardef['name']}').setAttribute('style','display:none;');".'</script>
                                {/literal}';
                        }
                    }
                    if ($this->displayParams['collection_field_list'][$k]['displayParams']['hidden']) {
                        $this->displayParams['to_display'][$key_value][$name]['field'] .= 
                            '{literal}
                                <script type="text/javascript">'."document.getElementById('{$collection_field_vardef['name']}').parentNode.setAttribute('style','padding: 0px;margin: 0px;');".'</script>
                            {/literal}';
                    }
                }
            }
            foreach($this->displayParams['collection_field_list'] as $k=>$v){
                if (!isset($this->displayParams['collection_field_list'][$k]['displayParams']['hidden'])) {
                    if (isset($this->displayParams['collection_field_list'][$k]['label']) && !empty($this->displayParams['collection_field_list'][$k]['label'])) {
                        $this->displayParams['collection_field_list'][$k]['label'] = "{sugar_translate label='{$this->displayParams['collection_field_list'][$k]['label']}' module='{$this->related_module}'}";
                    } else {
                        $this->displayParams['collection_field_list'][$k]['label'] = "{sugar_translate label='{$GLOBALS['dictionary'][$relatedObject]['fields'][$v['name']]['vname']}' module='{$this->related_module}'}";
                        }
                }
            }
        }
    }
/*  */

    /*
     * Init the template with the variables
     */
    function init_tpl(){
        foreach($this->extra_var as $k=>$v){
            $this->ss->assign($k,$v);
        }
        if($this->action_type == 'editview'){
/* It's for date fields - start */
            global $timedate, $current_user;
            $this->ss->assign('CALENDAR_DATEFORMAT', $timedate->get_cal_date_format());
            $this->ss->assign('USER_DATEFORMAT', $timedate->get_user_date_format());
            $time_format = $timedate->get_user_time_format();
            $this->ss->assign('TIME_FORMAT', $time_format);

            $date_format = $timedate->get_cal_date_format();
            $time_separator = ':';
            $match='';
            if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)){
                $time_separator = $match[1];
            }
            $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
            if (!isset($match[2]) || $match[2] == ''){
                $this->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M');
            }
            else{
                $pm = $match[2] == 'pm' ? '%P' : '%p';
                $this->ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M' . $pm);
            }
            $this->ss->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());
            $this->ss->assign('TIME_SEPARATOR', $time_separator);
/* It's for date fields - end */
        }
        $this->ss->assign('count_values',$this->count_values);
        $this->ss->assign('count',count($this->count_values)-1);
        $this->ss->assign('displayParams',$this->displayParams);
        $this->ss->assign('vardef',$this->vardef);
        $this->ss->assign('module',$this->related_module);
        $this->ss->assign('values',$this->bean->{$this->value_name});
        $this->ss->assign('showSelectButton',$this->showSelectButton);
        $this->ss->assign('hideShowHideButton',$this->hideShowHideButton);
        $this->ss->assign('APP',$GLOBALS['app_strings']);
    }
    /*
     * Display the collection field after retrieving the cached row.
     */
    function display(){
        $cacheRowFile = sugar_cached('modules/') . $this->module_dir .  '/collections/'.$this->viewtype. $this->name .'_'. count($this->count_values) . '.tpl';
        if(!$this->checkTemplate($cacheRowFile)){
            $dir = dirname($cacheRowFile);
            if(!file_exists($dir)) {

               mkdir_recursive($dir, null, true);
            }
            $cacheRow = $this->ss->fetch($this->findTemplate('Collection'.$this->viewtype.'Row'));

            file_put_contents($cacheRowFile, $cacheRow);
        }
        $this->ss->assign('cacheRowFile', $cacheRowFile);   
        return $this->ss->fetch($cacheRowFile);
    }
    /*
     * Check if the template is cached
     * return a bool
     */
    function checkTemplate($cacheRowFile){
        if(inDeveloperMode() || !empty($_SESSION['developerMode'])){
            return false;
        }
        return file_exists($cacheRowFile);
    }


    function findTemplate($view){
        static $tplCache = array();

        if ( isset($tplCache[$this->type][$view]) ) {
            return $tplCache[$this->type][$view];
        }

        $lastClass = get_class($this);
        $classList = array($this->type,str_replace('ViewSugarField','',$lastClass));
        while ( $lastClass = get_parent_class($lastClass) ) {
            $classList[] = str_replace('ViewSugarField','',$lastClass);
        }

        $tplName = '';
        foreach ( $classList as $className ) {
            global $current_language;
            if(isset($current_language)) {
                $tplName = 'include/SugarFields/Fields/'. $className .'/'. $current_language . '.' . $view .'.tpl';
                if ( file_exists('custom/'.$tplName) ) {
                    $tplName = 'custom/'.$tplName;
                    break;
                }
                if ( file_exists($tplName) ) {
                    break;
                }
            }
            $tplName = 'include/SugarFields/Fields/'. $className .'/'. $view .'.tpl';
            if ( file_exists('custom/'.$tplName) ) {
                $tplName = 'custom/'.$tplName;
                break;
            }
            if ( file_exists($tplName) ) {
                break;
            }
        }

        $tplCache[$this->type][$view] = $tplName;

        return $tplName;
    }
}
