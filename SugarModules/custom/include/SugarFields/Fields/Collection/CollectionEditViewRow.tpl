{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
<script type="text/javascript">
    var collection{$vardef.name} = (typeof collection{$vardef.name} == 'undefined') ? new Array() : collection{$vardef.name};
    collection{$vardef.name} = new SUGAR.collection('{$displayParams.formName}', '{$vardef.name}', '{$module}', '');
    collection{$vardef.name}.fields_count = '{$count}';
    collection{$vardef.name}.field_row_change('{$count}','open');
</script>
<div id="{$displayParams.formName}_{$vardef.name}" name="{$displayParams.formName}_{$vardef.name}">
    <span class="id-ff">
        <button class="button" type="button" name="remove_{$vardef.name}_collection_0" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.selected_remove();">
            <img id="removeButton_collection_0" name="removeButton_collection_0" src="{sugar_getimagepath file="id-ff-remove-nobg.png"}"/>
            <p value={$APP.LBL_DELETE_BUTTON}></p>
        </button>
        <button class="button" type="button" name="allow_new_value_{$vardef.name}_collection_0" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.create_clone();collection{$vardef.name}.add();collection{$vardef.name}.clean_current();">
            <img id="addButton_collection_0" name="addButton_collection_0" src="{sugar_getimagepath file="id-ff-add.png"}"/>
            <p value={$APP.LBL_ADD_BUTTON}></p>
        </button>
    </span>
<input hidden="hidden" id="collection_{$vardef.name}" name="collection_{$vardef.name}" value="{$vardef.name}">
<input hidden="hidden" id="collection_{$vardef.name}_remove" name="collection_{$vardef.name}_remove" value="">
<input hidden="hidden" id="collection_{$vardef.name}_change" name="collection_{$vardef.name}_change" value="">
<table id="table_collection_{$vardef.name}" style="border-collapse:collapse;border-top:solid 1px #999999;border-left:solid 1px #999999;border-right:solid 1px #999999; margin-top: 5px !important;border-radius: 6px;display: block;">
    <tr id="lineLabel_{$displayParams.formName}_{$vardef.name}" name="lineLabel_{$displayParams.formName}_{$vardef.name}" style="font-weight: bold;">
        <td style="width: 5%; padding: 5px 5px 10px 5px !important; text-align: center;border-right: solid 1px #999999;">
            <span>{$APP.LBL_LINK_SELECT}</span>
        </td>
        {foreach item=extra_field from=$displayParams.collection_field_list key=key_extra}
            {if $extra_field.label != ''}
                <td style="padding: 5px 5px 10px 5px !important; text-align: center;{if $extra_field.displayParams.size != ''}width:{$extra_field.displayParams.size}{/if}">
                    {$extra_field.label}
                </td>
            {else}
                <td></td>
            {/if}
        {/foreach}
        <td style="width: 5%; padding: 5px 5px 10px 5px !important; text-align: center;border-left: solid 1px #999999;">
            <span>{$APP.LBL_ID_FF_CLEAR}</span>
        </td>

   </tr>
    {foreach item=extra_value from=$count_values key=key_extra_value}
        <tr id="lineFields_{$displayParams.formName}_{$vardef.name}_{$extra_value}">
            <td style="width: 5%; padding: 5px 5px 10px 5px !important; text-align: center;border-right: solid 1px #999999;">
                <input onclick="this.value=='0' ? this.value='1' : this.value='0';" type="checkbox" id="check_{$vardef.name}_collection_{$extra_value}" name="check_{$vardef.name}_collection_{$extra_value}" value='0' {if $extra_value == '0'}style="display:none"{/if}>
            </td>
            {foreach item=extra_field from=$displayParams.to_display.$extra_value key=key_extra}
                {if !empty($extra_field.field)}
                    {if $extra_field.hidden != 'hidden'}
                        <td nowrap style="padding: 5px 5px 10px 5px !important; vertical-align: middle;">
                            {$extra_field.field}
                        </td>
                    {else}
                        <td>{$extra_field.field}</td>
                    {/if}
                {/if}
            {/foreach}
            <td style="border-left: solid 1px #999999; text-align: center; vertical-align: middle;">
                <span class="id-ff multiple">
                    <button class="button" type="button" name="clean_{$vardef.name}_collection_{$extra_value}" id="clean_{$vardef.name}_collection_{$extra_value}" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.clean_current(this.id);collection{$vardef.name}.field_row_change(this.id,'clean');">
                        <img id="addButton_collection_{$extra_value}" name="addButton_collection_{$extra_value}" src="{sugar_getimagepath file="id-ff-clear.png"}"/>
                    </button>
                </span>
            </td>
       </tr>
   {/foreach}
</table>
<script type="text/javascript">
    var tableelement = document.getElementById('table_collection_{$vardef.name}');
    collection{$vardef.name}.correctnewpage(tableelement);
</script>
</div>