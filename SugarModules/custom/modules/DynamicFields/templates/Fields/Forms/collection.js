jQuery(document).ready(function($){
    CustomModuleBuilder={
        collection:{
            idField:'collectionfield_',
            idSize:'collectionsize_',
            totalSize:0,
            maxSize:0,
            numberFields:0,
            selectedFields:[],
            selectedSizes:[],
            controlSize:function(cur){
                let curNum=$(cur).attr('id').split(CustomModuleBuilder.collection.idSize)[1];
                if(typeof(CustomModuleBuilder.collection.selectedSizes[curNum])!=='undefined'){
                    CustomModuleBuilder.collection.totalSize=CustomModuleBuilder.collection.totalSize-CustomModuleBuilder.collection.selectedSizes[curNum];
                }
                CustomModuleBuilder.collection.selectedSizes[curNum]=$(cur).val();
                CustomModuleBuilder.collection.totalSize=CustomModuleBuilder.collection.totalSize + Math.abs(CustomModuleBuilder.collection.selectedSizes[curNum]);
                let delta=CustomModuleBuilder.collection.maxSize-CustomModuleBuilder.collection.totalSize;
                for (let n=0;n<=Collection.numberFields;n++){
                    $('#'+CustomModuleBuilder.collection.idSize+n).children('option').removeAttr('disabled');
                    $('#'+CustomModuleBuilder.collection.idSize+n).children('option').each(function(ind,elem){
                        if($(elem).val()>delta && $(elem).val()!=CustomModuleBuilder.collection.selectedSizes[n]){
                            $(elem).attr('disabled','disabled');
                        }
                    });
                };
                if(CustomModuleBuilder.collection.maxSize==CustomModuleBuilder.collection.totalSize){
                    $('input[name="fsavebtn"]').removeAttr('disabled');
                }
            },
            controlField:function(cur){
                let curNum=$(cur).attr('id').split(CustomModuleBuilder.collection.idField)[1];
                CustomModuleBuilder.collection.selectedFields[curNum]=$(cur).val();
                for (let n=0;n<=Collection.numberFields;n++){
                    $('#'+CustomModuleBuilder.collection.idField+n).children('option').removeAttr('disabled');
                    $('#'+CustomModuleBuilder.collection.idField+n).children('option').each(function(ind,elem){
                        if(CustomModuleBuilder.collection.selectedFields.includes($(elem).val()) && $(elem).val()!=CustomModuleBuilder.collection.selectedFields[n]){
                            $(elem).attr('disabled','disabled');
                        }
                    });
                };
                let nextNum=Math.abs(curNum)+1;
                $('#'+CustomModuleBuilder.collection.idField+nextNum).removeAttr('disabled');
                $('#'+CustomModuleBuilder.collection.idSize+nextNum).removeAttr('disabled');
            },
            init:function(numberFields){
                CustomModuleBuilder.collection.checkButtons();
                Collection.numberFields=Math.abs(numberFields)-1;
                for(let k=1;k<=Collection.numberFields;k++){
                    $('#'+CustomModuleBuilder.collection.idField+k).attr('disabled','disabled');
                    $('#'+CustomModuleBuilder.collection.idSize+k).attr('disabled','disabled');
                }
                let lsize=Object.keys(Collection.size).length-1;
                CustomModuleBuilder.collection.maxSize=Object.keys(Collection.size)[lsize];
                if(typeof(Collection.selections)==='object'){
                    CustomModuleBuilder.collection.lockFieldSize();
                }else{
                    CustomModuleBuilder.collection.fixFieldName();
                }
            },
            moduleLoadFieldParams: function(name,current) {
                let linkid=$(current).val();
                ModuleBuilder.getContent('module=ModuleBuilder&action=modulefield&view_package=' + ModuleBuilder.MBpackage +
                  '&view_module=' + ModuleBuilder.module + '&field=' + name + '&type=collection&collectionModule='+linkid);
                  SUGAR.ajaxUI.showLoadingPanel();
            },
            fixFieldName: function(){
                $('#field_name_id').val($('#'+Collection.fieldName).val());
                eval($('#field_name_id').attr('onchange'));
                $('#field_name_id').after($('#'+Collection.fieldName));
                $('#'+Collection.fieldName).removeAttr('hidden');
                $('#'+Collection.fieldName).attr('disabled','disabled');
                $('#field_name_id').attr('hidden','hidden');
            },
            checkButtons(){
                let names=['fsavebtn','fclonebtn'];
                for(let k=0;k<names.length;k++){
                    $('input[name="'+names[k]+'"]').attr('disabled','disabled');
                }
            },
            lockFieldSize(){
                for (let n=0;n<=Collection.numberFields;n++){
                    let field=Object.keys(Collection.selections)[n];
                    let size=Object.values(Collection.selections)[n];
                    $('#'+CustomModuleBuilder.collection.idField+n+' option[label="'+field+'"]').prop('selected',true);
                    $('#'+CustomModuleBuilder.collection.idField+n).attr('disabled','disabled');
                    CustomModuleBuilder.collection.selectedFields[n]=field;
                    if(typeof(field)!=='undefined'){
                        $('#selected'+CustomModuleBuilder.collection.idField+n).val(field);
                    }else{
                        $('#selected'+CustomModuleBuilder.collection.idField+n).remove();
                    }
                    CustomModuleBuilder.collection.selectedSizes[n]=size;
                    if(typeof(size)!=='undefined'){
                        $('#'+CustomModuleBuilder.collection.idSize+n).removeAttr('disabled');
                        $('#'+CustomModuleBuilder.collection.idSize+n+' option[label="'+size+'"]').prop('selected',true);
                    }else{
                        $('#'+CustomModuleBuilder.collection.idSize+n).attr('disabled','disabled');
                    }
                }
                CustomModuleBuilder.collection.totalSize=CustomModuleBuilder.collection.maxSize;
                $('input[name="fsavebtn"]').removeAttr('disabled');
                CustomModuleBuilder.collection.controlSize($('#'+CustomModuleBuilder.collection.idSize+'0'));
            }
        }
    };
});