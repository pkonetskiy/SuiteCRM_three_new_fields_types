{*
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/


*}
{if $support}
    {include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
{else}
    <span class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_NOT_SUPPORT"}</span>
{/if}
{* {include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"} *}