{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0.2 2021-04-20
 *  
 ********************************************************************************/
*}

<div id='{{sugarvar key='name'}}_image_div' name='{{sugarvar key='name'}}_image_div'><img src="{sugar_getimagepath file='sqsWait.gif'}" alt="loading..." id="{{sugarvar key="name"}}_loading_img" style="display:none"></div>
<div id='{{sugarvar key='name'}}_div' name='{{sugarvar key='name'}}_div'></div>
<script type="text/javascript">
    document.getElementById('{{sugarvar key="name"}}_image_div').parentElement.previousElementSibling.style.width="10%";
    document.getElementById('{{sugarvar key="name"}}_image_div').parentElement.style.width="90%";
{literal}
    var callback = {
        success:function(o){
           {/literal}
            document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="none";
            document.getElementById('{{sugarvar key="name"}}_div').innerHTML = o.responseText;
            SUGAR.util.evalScript(o.responseText);
            {literal}
        },
        failure:function(o){
            alert(SUGAR.language.get('app_strings','LBL_AJAX_FAILURE'));
        }
    }
    {/literal}
    var action_type = 'editview';
    if (document.getElementById('{{sugarvar key="name"}}_collection_action_type'))
        if (document.getElementById('{{sugarvar key="name"}}_collection_action_type').value != '')
            var action_type = document.getElementById('{{sugarvar key="name"}}_collection_action_type').value;
    document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="inline";
{literal}
    if (typeof(document.forms.EditView) == 'undefined')
        for(let s=0; s < document.forms.length; s++){
            if (document.forms[s].getAttribute("name").indexOf('QuickCreate') >= 0) {
                var formnamefound = document.forms[s].getAttribute("name");
            }
            if (document.forms[s].getAttribute("name").indexOf('EditView') >= 0) {
                var formnamefound = document.forms[s].getAttribute("name");
            }
        }
     else{
         var formnamefound = 'EditView';
     }
{/literal}
    var postData = '&displayParams=' + '{{$displayParamsJSON}}' + '&vardef=' + '{{$vardefJSON}}' + '&module_dir=' + document.forms[formnamefound].module.value + '&bean_id=' + document.forms[formnamefound].record.value + '&action_type=' + action_type + '&form_name=' + formnamefound;
    {literal}
/* support duplicate */
    if(typeof(document.getElementsByName('duplicateId')[0])!=='undefined'){
        postData = postData + '&duplicateId='+document.getElementsByName('duplicateId')[0].value;
    }
/* */
    YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfieldcollection', callback, postData);
{/literal}
</script>