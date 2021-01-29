{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}

{if empty({{sugarvar key='value' string=true}})}
{assign var="value" value={{sugarvar key='default_value' string=true}}}
{else}
{assign var="value" value={{sugarvar key='value' string=true}}}
{/if}
{{capture name=idname assign=idname}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
    {{assign var=idname value=$displayParams.idName}}
{{/if}}
{{if !$vardef.gen}}
	{if !empty({{sugarvar key='value' string=true}})}
{*            <a href="index.php?action=linkfiledownload&id={{sugarvar key='value'}}&type={$module}"  name='{{$idname}}' id='{{$idname}}' class="tabDetailViewDFLink">{{sugarvar key='realyname'}}</a> *}
            <a href="index.php?action=linkfiledownload&id={{sugarvar key='value'}}&type={$module}"  name='{{$idname}}' id='{{$idname}}' class="tabDetailViewDFLink"><img src="{{sugar_getimagepath file_name=Documents file_extension='svg'}}"/></a>
	{else}
            <span type='text' name='{{$idname}}' id='{{$idname}}' size='{{$displayParams.size|default:30}}' </span>
	{/if}
{{/if}}