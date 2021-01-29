<?php
if (!defined('sugarEntry') || !sugarEntry) {die('Not A Valid Entry Point');}
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/

require_once('custom/include/SugarFields/Fields/Collection/SugarFieldCollection.php');
class SugarFieldCollection_files extends SugarFieldCollection {
	public function save(&$bean, $params, $field, $properties, $prefix = ''){
        if($bean->field_defs[$field]['type'] == 'collection_files'){
            $relationship=$bean->field_defs[$field]['relationship_name'];
            foreach ($bean->field_defs as $field_name => $field_params) {
                if($field_params['relationship']==$relationship){
                    $link_field=$field_params['name'];
                }
            }
        }else{
            $link_field = $params[$field];
        }
        if(!empty($link_field) && ($bean->field_defs[$link_field]['type'] == 'link')){
            $bean->load_relationship($link_field);
            $actual_field_list = Array();
            foreach($params as $name=>$value){
                $explode_string = '_'.$link_field.'_collection_';
                $new_array = explode($explode_string, $name);
                if (count($new_array) == 2)
                    $actual_field_list[$new_array[1]][$new_array[0]] = $value;
            }
            $bean_name = $bean->field_defs[$link_field]['bean_name'];
            $filefilds = $_FILES['files'.$link_field];
            $countfiles = count($filefilds['error']);
            include_once 'include/upload_file.php';
            $destination = "upload://";
            if(UploadStream::writable()) {
                for ($i = 0; $i < $countfiles; $i++){
                    if ($filefilds['error'][$i] == 0 && $filefilds['size'][$i] != 0){
                        if(is_uploaded_file($filefilds['tmp_name'][$i])) {
                            $bean_collection = new $bean_name();
                            $bean_collection->filename = $filefilds['name'][$i];
                            $bean_collection->mime_type = $filefilds['type'][$i];
                            $bean_collection->assigned_user_id = $bean->assigned_user_id;
                            $bean_collection->save();
                            if (empty($bean->id)){
                                $bean->id = create_guid();
                                $bean->new_with_id=true;
                            }
                            $bean->{$link_field}->add($bean_collection);
                            // save file with new name 
                            if(!UploadStream::move_uploaded_file($filefilds['tmp_name'][$i], $destination.$bean_collection->id."__".$bean_collection->module_name)) {
                                $GLOBALS['log']->fatal("ERROR: SugarFieldCollection_files can't move_uploaded_file to $destination. You should try making the directory writable by the webserver");
                            }
                        }
                    }
                }
            }

            $change_list = Array();
            $change_list = explode(';', $params['collection_'.$link_field.'_change']);
            foreach($actual_field_list as $key => $value_list){
                if(in_array($key, $change_list)) {
                    $bean_collection = new $bean_name();
                    if (!empty($value_list['id'])) {
                        $bean_collection->retrieve($value_list['id']);
                    }
                    $empty_field = 0;
                    foreach($value_list as $name=>$value){
                        if ($name != 'id' && $name != 'filename') {
                            $bean_collection->$name = $value;
                        } else {
                            if ($name == 'filename' && !empty($value)) {
                                $bean_collection->$name = $value;
                            }
                        }
                        if ($bean_collection->$name!==$bean_collection->fetched_row[$name]) {
                            $empty_field++;
                        }
                    }
                    if ($empty_field > 0) {
                        $bean_collection->assigned_user_id = $bean->assigned_user_id;
                        $bean_collection->save();
                        if (empty($bean->id)){
                            $bean->id = create_guid();
                            $bean->new_with_id=true;
                        }
                        $bean->{$link_field}->add($bean_collection);
                    }
                }
            }
            $delete_id_list = explode(';', $params['collection_'.$link_field.'_remove']);
            foreach ($delete_id_list as $delete_id) {
                if (!empty($delete_id)){
                    $bean_collection = new $bean_name();
                    $bean_collection->retrieve($delete_id);
                    $bean_collection->mark_deleted($delete_id);
                    // save file with current name
                    if (is_file($destination.$delete_id."__".$bean_collection->module_name)){
                        unlink($destination.$delete_id."__".$bean_collection->module_name);
                    }
                }
            }
        }
    }
}