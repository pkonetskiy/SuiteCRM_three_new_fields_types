/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
SUGAR.dynamicbase = function(viewtype,field,values){
    this.viewtype=viewtype;
    this.field=field;
    this.values=JSON.parse(values);
    this.domField="div[field='"+this.field+"'][type='dynamicbase']";
    this.addField='add_button_'+field;
    this.removeField='remove_button_'+field;
    this.init();
};
SUGAR.dynamicbase.prototype = {
    init: function(){
        this.addValues();
        if (this.viewtype==='EditView'){
            $('#'+this.addField).off().on('click',{dF:this.domField,t:'input'},this.addButton);
            $('#'+this.removeField).off().on('click',{dF:this.domField,field:this.field},this.removeButton);
        }
    },
    addValues: function(){
        let keys=Object.keys(this.values);
        let values=Object.values(this.values);
        this.insertValue(keys[0],values[0],0);
        for (let k=1; k<keys.length; k++){
            let tag='span';
            if (this.viewtype==='EditView'){
                tag='input';
            }
            this.addButton(this.domField,tag);
            this.insertValue(keys[k],values[k],k);
        }
    },
    insertValue: function(key,value,k){
        $('#'+this.field+'_'+k).val(value);
        $('#'+'id_'+this.field+'_'+k).val(key);
        if (this.viewtype==='DetailView'){
            $('#'+this.field+'_'+k).html(value);
        }
    },
    addButton: function(dF,t){
        var field='';
        let tag='';
        var blockPar='';
        if(typeof(dF)==='string'){
            field=$(dF).attr('field');
            blockPar=dF;
            tag=t;
        }else{
            field=$(dF.data.dF).attr('field');
            blockPar=dF.data.dF;
            tag=dF.data.t;
        }
        $(blockPar).append($('#block_'+field+'_0').clone());
        let bl=$(blockPar).children('div').length-1;
        let divBlocks=$(blockPar).children('div').last();
        $(divBlocks).attr('id','block_'+field+'_'+bl);
        if(tag==='input'){
            $(divBlocks).find(tag+':nth-child(1)').css({'display':'inline-block'});
            $(divBlocks).find(tag+':nth-child(1)').attr('id','check_'+field+'_'+bl);
            $(divBlocks).find(tag+':nth-child(1)').attr('name','check_'+field+'_'+bl);
            $(divBlocks).find(tag+':nth-child(2)').attr('id',field+'_'+bl);
            $(divBlocks).find(tag+':nth-child(2)').css({'margin-left':'0px'});
            $(divBlocks).find(tag+':nth-child(2)').val('');
            $(divBlocks).find(tag+':nth-child(3)').attr('id','id_'+field+'_'+bl);
            $(divBlocks).find(tag+':nth-child(3)').val('');
        }else{
            $(divBlocks).find(tag+':nth-child(1)').attr('id',field+'_'+bl);
            $(divBlocks).find(tag+':nth-child(1)').css({'margin-left':'0px'});
            $(divBlocks).find(tag+':nth-child(1)').val('');
        }
    },
    removeButton: function(dF){
        let divBlocks=$(dF.data.dF).children('div');
        let checks=$(divBlocks).find('input:nth-child(1)');
        let remSel='#remove_list_'+dF.data.field+'_dynamicbase';
        for(let k=0 ; k<$(checks).length;k++){
            if ($($(checks)[k]).val()=='1'){
                let rl=$(remSel).val();
                let jprl={};
                if(rl!==''){
                    jprl=JSON.parse(rl);
                }
                jprl[k]=$($(divBlocks)[k]).find('input:nth-child(3)').val();
                $(remSel).val(JSON.stringify(jprl));
                $($(divBlocks)[k]).remove();
            }
        }
    }
};