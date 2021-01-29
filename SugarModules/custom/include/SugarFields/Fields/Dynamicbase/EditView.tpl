{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
<script type="text/javascript" src="{{$scriptfield}}"></script>
<span class="id-ff">
    <button class="button" type="button" id="remove_button_{{$vardef.name}}" name="remove_button_{{$vardef.name}}" tabindex="{{$tabindex}}" class="utilsLink">
        <img id="removeButton_collection_0" id="remove_image_{{$vardef.name}}" name="remove_image_{{$vardef.name}}" src="{sugar_getimagepath file="id-ff-remove-nobg.png"}"/>
        <p value={$APP.LBL_DELETE_BUTTON}></p>
    </button>
    <button class="button" type="button" id="add_button_{{$vardef.name}}" name="add_button_{{$vardef.name}}" tabindex="{{$tabindex}}" class="utilsLink">
        <img id="addButton_collection_0" id="add_image_{{$vardef.name}}" name="add_image_{{$vardef.name}}" src="{sugar_getimagepath file="id-ff-add.png"}"/>
        <p value={$APP.LBL_ADD_BUTTON}></p>
    </button>
</span>
<script>
{literal}
    jQuery(document).ready(function($){ 
        let callback = {
            success:function(o){
{/literal}
                var Obj{{$vardef.name}}=new SUGAR.dynamicbase('{{$viewtype}}','{{$vardef.name}}',o.responseText);
{literal}
            },
            failure:function(o){
                alert(SUGAR.language.get('app_strings','LBL_AJAX_FAILURE'));
            }
        }
{/literal}
        let postData ='&module=' + document.forms.EditView.module.value + '&bean_id=' + document.forms.EditView.record.value + '&name_field={{$vardef.name}}';
{literal}
        YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfielddynamicbase', callback, postData);
    });
{/literal}
</script>
<input type="hidden" name="remove_list_{{$vardef.name}}_dynamicbase" id="remove_list_{{$vardef.name}}_dynamicbase" value="">
<div id="block_{{$vardef.name}}_0" class="edit-view-row-item">
    <input id="check_{{$vardef.name}}_0" name="check_{{$vardef.name}}_0" type="checkbox" onclick="this.value=='0' ? this.value='1' : this.value='0';" style='margin: 5px 10px;display:none' value='0' >
    <input name="{{$vardef.name}}[]" id="{{$vardef.name}}_0" type="text" value="" style="width:80%;margin-left:38px;">
    <input name="id_{{$vardef.name}}[]" id="id_{{$vardef.name}}_0" type="hidden" value="">
</div>