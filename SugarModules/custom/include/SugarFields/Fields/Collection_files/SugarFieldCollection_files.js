/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
if(typeof(SUGAR.collectionfiles) == "undefined") {
    SUGAR.collectionfiles = function(form_name, field_name, module, totalfieldsin){
        this.form = form_name;
        this.field = field_name;
        this.module = module;
        this.filesid = new Array();
        this.totalfieldsin = totalfieldsin;
    };
    SUGAR.collectionfiles.prototype = {
        add_new_files: function (id) {
            document.getElementById('list_files'+this.field).innerHTML = '';
            var output = [];
            var list_files = document.getElementById(id).files;
            for (let i = 0, f; f = list_files[i]; i++) {
                let fileSize= String(f.size).split(/(?=(?:\d{3})+$)/);
                let nameSizes=['','Kb','Mb','Gb'];
                let textFileSize='-';
                if (fileSize.length<=4){
                    textFileSize=Math.abs(fileSize[0])+Math.round(fileSize[1]/1000)+' '+nameSizes[fileSize.length-1];
                }else{
                    textFileSize=f.size;
                }
                output.push('<li><i>', f.name, '</i><span style="float:right">', textFileSize || '-', '</span>', '</li>');
            }
            document.getElementById('list_files'+this.field).innerHTML = '<ul style="list-style-type:disc;margin-left: 20px;">' + output.join('') + '</ul>';
        }
    };
}