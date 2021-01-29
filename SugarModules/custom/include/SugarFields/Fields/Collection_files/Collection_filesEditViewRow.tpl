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
{* Files *}
    var collectionfiles{$vardef.name} = new SUGAR.collectionfiles('{$displayParams.formName}', '{$vardef.name}', '{$module}', '');
    document.getElementById('{$displayParams.formName}').enctype="multipart/form-data";
{* *}
</script>
<div id="{$displayParams.formName}_{$vardef.name}" name="{$displayParams.formName}_{$vardef.name}">
{* Files *}
        <strong style="width: 50%;float:left;text-align: center;">{$dropFiles}</strong><strong style="width: 50%;float:left;text-align: center;">{$listFiles}</strong>
        <div id="drop_zone{$vardef.name}" style="float: left; display: inline-block;min-height: 72px;width: 50%; border: solid 1px #999999;text-align: center;border-radius: 6px 0px 0px 6px;">
            <input type="file" id="files{$vardef.name}" name="files{$vardef.name}[]" multiple onchange="collectionfiles{$vardef.name}.add_new_files(this.id)" style="display: inline-block;line-height: 58px;width: 100%;text-align: center;"/>
        </div>
        <div id="list_files{$vardef.name}" name="list_files{$vardef.name}" style="padding: 5px;display: inline-block;width: 50%; min-height: 72px; border: solid 1px #999999;border-radius: 0px 6px 6px 0px;"></div>
    <span class="id-ff">
        <button class="button" type="button" name="remove_{$vardef.name}_collection_0" tabindex="{$tabindex}" class="utilsLink" onclick="collection{$vardef.name}.selected_remove();">
            <img id="removeButton_collection_0" name="removeButton_collection_0" src="{sugar_getimagepath file="id-ff-remove-nobg.png"}"/>
            <p value={$APP.LBL_DELETE_BUTTON}></p>
        </button>
    </span>
{* *}
<input hidden="hidden" id="collection_{$vardef.name}" name="collection_{$vardef.name}" value="{$vardef.name}">
<input hidden="hidden" id="collection_{$vardef.name}_remove" name="collection_{$vardef.name}_remove" value="">
<input hidden="hidden" id="collection_{$vardef.name}_change" name="collection_{$vardef.name}_change" value="">
<table id="table_collection_{$vardef.name}" style="display:block;border-collapse:separate;border:solid 1px #999999; margin-top: 5px !important;border-radius: 6px;">
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
   </tr>
    {foreach item=extra_value from=$count_values key=key_extra_value}
        <tr id="lineFields_{$displayParams.formName}_{$vardef.name}_{$extra_value}">
            <td style="width: 5%; padding: 5px 5px 10px 5px !important; text-align: center;border-right: solid 1px #999999;">
                <input onclick="this.value=='0' ? this.value='1' : this.value='0';" type="checkbox" id="check_{$vardef.name}_collection_{$extra_value}" name="check_{$vardef.name}_collection_{$extra_value}" value='0'>
            </td>
            {foreach item=extra_field from=$displayParams.to_display.$extra_value key=key_extra}
                {if $extra_field.hidden != 'hidden'}
                    <td nowrap style="padding: 5px 5px 10px 5px !important; vertical-align: middle;">
                        {$extra_field.field}
                    </td>
                {else}
                    <td>{$extra_field.field}</td>
                {/if}
            {/foreach}
       </tr>
   {/foreach}
</table>
</div>
<script type="text/javascript">
    var tableelement = document.getElementById('table_collection_{$vardef.name}');
    collection{$vardef.name}.correctnewpage(tableelement);
    var checkid = document.getElementById('id_{$vardef.name}_collection_0').value;
    if (checkid === null || checkid ==='')
        document.getElementById('lineFields_{$displayParams.formName}_{$vardef.name}_0').remove();
</script>
{*  *}