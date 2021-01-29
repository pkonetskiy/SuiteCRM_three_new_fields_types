<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
require_once('custom/include/SugarFields/Fields/Collection/ViewSugarFieldCollection.php');


class ViewSugarFieldCollection_files extends ViewSugarFieldCollection{
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
                    // set file name
                    $this->value_name[$k]['link_file'] = $this->value_name[$k]['id'].'__'.$new_bean->module_name;
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
                    if (isset($this->displayParams['collection_field_list'][$k]['customCode']) && !empty($this->displayParams['collection_field_list'][$k]['customCode']) && $this->viewtype != 'DetailView' && $collection_field_vardef['type'] != 'Link_file') {
                        $customCode = str_replace('value=""', 'value="'.$collection_field_vardef['value'].'"', $this->displayParams['collection_field_list'][$k]['customCode']);
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
                        if ($collection_field_vardef['type'] == 'Link_file') {
                            $key_file_name = str_replace($this->displayParams['to_display'][$key_value][$name]['vardefName'].'_', '', $name);
                            $this->displayParams['to_display'][$key_value][$name]['realyname'] = $this->displayParams['to_display'][$key_value]['filename_'.$key_file_name]['value'];
                        }
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
    function display(){
        global $app_list_strings;
        $cacheRowFile = sugar_cached('modules/') . $this->module_dir .  '/collections_files/'.$this->viewtype. $this->name .'_'. count($this->count_values) .  '.tpl';
        $this->ss->assign('dropFiles', $app_list_strings['fieldType_collection_files']['LBL_DROP']);
        $this->ss->assign('listFiles', $app_list_strings['fieldType_collection_files']['LBL_FILE_SIZE']);
        if(!$this->checkTemplate($cacheRowFile)){
            $dir = dirname($cacheRowFile);
            if(!file_exists($dir)) {

               mkdir_recursive($dir, null, true);
            }
            $cacheRow = $this->ss->fetch($this->findTemplate('Collection_files'.$this->viewtype.'Row'));

            file_put_contents($cacheRowFile, $cacheRow);
        }
        $this->ss->assign('cacheRowFile', $cacheRowFile);   
        return $this->ss->fetch($cacheRowFile);
    }
}
