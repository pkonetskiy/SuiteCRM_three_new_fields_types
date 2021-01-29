{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
<div id='{{sugarvar key='name'}}_div' name='{{sugarvar key='name'}}_div'><img src="{sugar_getimagepath file='sqsWait.gif'}" alt="Loading..." id="{{sugarvar key="name"}}_loading_img" style="display:none"></div>
<script type="text/javascript">
//{literal}
    var callback = {
        success:function(o){
            //{/literal}
            document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="none";
            document.getElementById('{{sugarvar key="name"}}_div').innerHTML = o.responseText;
            SUGAR.util.evalScript(o.responseText);
            //{literal}
        },
        failure:function(o){
            alert(SUGAR.language.get('app_strings','LBL_AJAX_FAILURE'));
        }
    }
    //{/literal}
    document.getElementById('{{sugarvar key="name"}}_loading_img').style.display="inline";
    postData = '&displayParams=' + '{{$displayParamsJSON}}' + '&vardef=' + '{{$vardefJSON}}' + '&module_dir=' + document.forms.DetailView.module.value + '&bean_id=' + document.forms.DetailView.record.value + '&action_type=detailview';
    //{literal}
    YAHOO.util.Connect.asyncRequest('POST', 'index.php?action=viewsugarfieldcollection', callback, postData);
//{/literal}
</script>