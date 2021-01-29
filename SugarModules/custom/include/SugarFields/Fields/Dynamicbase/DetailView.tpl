{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
<script type="text/javascript" src="{{$scriptfield}}"></script>
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
        let postData='&module=' + document.forms.DetailView.module.value + '&bean_id=' + document.forms.DetailView.record.value + '&name_field={{$vardef.name}}';
{literal}
        YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfielddynamicbase', callback, postData);
    });
{/literal}
</script>
<div id="block_{{$vardef.name}}_0" style="width:100%;">
    <span id='{{$vardef.name}}_0' value='{{$value}}' style='width:100%'>{{$value}}</span>
</div>