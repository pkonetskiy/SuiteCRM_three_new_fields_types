{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
*}
{if $support}
    <table width="400px">
        <tr>
            <td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_SELECT_MODULE"}:</td>
            <td>
                {html_options name="collection_module" id="collection_module" options=$workModules onChange="CustomModuleBuilder.collection.moduleLoadFieldParams('',this);"}
                {sugar_help text=$mod_strings.LBL_POPHELP_COLLECTION_LINK FIXX=250 FIXY=80}
            </td>
        </tr>
        {if isset($collection.fieldName)}
            <tr>
                <td style="padding: 0px"></td>
                <td style="padding: 0px">
                    <input name="{$collection.fieldName}" id="{$collection.fieldName}" value="{$collection.fieldName}" hidden="hidden">
                </td>
            </tr>
        {/if}
        {if isset($collection.relationship_name)}
            <tr>
                <td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_SET_LINK"}:</td>
                <td>
                    <span>{$collection.relationship_name}</span>
                    <input name="relationship_name" id="relationship_name" value="{$collection.relationship_name}" hidden="hidden">
                </td>
            </tr>
        {/if}
    </table>
        {if isset($collection.module)}
            {include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
            </table>
            <table width="400px" id='collection_table'>
                <tr>
                    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_FIELD_OF_MODULE"} {$collection.module}:<span class="required">*</span></td>
                    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_FIELD_OF_SIZE"}{$collection.max_size}%):<span class="required">*</span></td>
                </tr>
                {counter start=0 skip=1 assign=number}
                {section name=numberFields loop=$numberFields}
                <tr>
                    <td class=''>
                        {if isset($collection.selections)}
                            <input name="collectionfield[]" id="selectedcollectionfield_{$number}" value="" hidden="hidden">
                        {/if}
                        {html_options name="collectionfield[]" id="collectionfield_$number" options=$collection.fields onChange="CustomModuleBuilder.collection.controlField(this);"}
                    </td>
                    <td>
                        {html_options name="collectionsize[]" id="collectionsize_$number" options=$collection.size onChange="CustomModuleBuilder.collection.controlSize(this);"}
                    </td>
                </tr>
                {counter}
                {/section}
                <tr>
                    <td class='mbLBL'></td>
                    <td>
                        <input name="collection_module_{$collection.module}" id="collection_module_{$collection.module}" value="{$collection.module}" hidden="hidden">
                    </td>
                </tr>
            </table>
        {/if}
{else}
<table width="400px">
    <tr>
        <td>
            <span class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_NOT_SUPPORT"}</span>
        </td>
        <td>
        </td>
    </tr>
</table>
{/if}
<script type="text/javascript" src="{$scriptfield}"></script>
<script type="text/javascript">
    $('input[name="fsavebtn"]').attr('disabled','disabled');
</script>
{if isset($collection.module)}
    <script type="text/javascript">
        {literal}jQuery(document).ready(function($){{/literal}
            Collection=JSON.parse('{$jsonCollection}');
            CustomModuleBuilder.collection.init('{$numberFields}');
        {literal}});{/literal}
    </script>
{/if}
{if isset($additionscriptfield)}
    <script type="text/javascript" src="{$additionscriptfield}"></script>
{/if}
{* {include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"} *}