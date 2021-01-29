function checkFixName(){
    if (typeof(Collection)!=='undefined'){
        if(Collection.relationship_name===$('#relationship_name').val()){
            CustomModuleBuilder.collection.fixFieldName();
        }else{
            setTimeout(checkFixName,50);
        }
    }else{
        setTimeout(checkFixName,50);
    }
};
checkFixName();