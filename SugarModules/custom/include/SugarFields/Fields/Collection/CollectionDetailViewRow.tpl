{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
<div id="{$displayParams.formName}_{$vardef.name}" name="{$displayParams.formName}_{$vardef.name}">
<table id="table_collection_{$vardef.name}" style="border-collapse:separate;border-top:solid 1px #999999;border-left:solid 1px #999999; margin-top: 5px !important;border-radius: 6px;width: 100%;">
    <tr style="font-weight: bold;" id="lineLabel_{$displayParams.formName}_{$vardef.name}" name="lineLabel_{$displayParams.formName}_{$vardef.name}">
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
            {if $extra_field.displayParams.hidden != 'hidden'}
                <th style="border-right:solid 1px #999999;border-radius: 0px 6px 0px 0px;padding: 5px 5px 10px 5px !important; text-align: center;{if $extra_field.displayParams.size != ''}width:{$extra_field.displayParams.size}{/if}">
                    {$extra_field.label}
                </th>
            {/if}
        {/foreach}
   </tr>
    {foreach item=extra_value from=$count_values key=key_extra_value}
        <tr id="lineFields_{$displayParams.formName}_{$vardef.name}_{$extra_value}">
            {foreach item=extra_field from=$displayParams.to_display.$extra_value key=key_extra}
                {if $extra_field.hidden != 'hidden'}
                    <td nowrap style="border-right:solid 1px #999999;padding: 5px 5px 10px 5px !important; vertical-align: middle;text-align: right;">
                        {$extra_field.field}
                    </td>
                {/if}
            {/foreach}
       </tr>
   {/foreach}
</table>
</div>