var communityMgr=(function(config,functions){
    var loadedData={};
    /**
     * 创建datatable
     * @returns {*|jQuery}
     */
    function createTable(){

        var ownTable=$("#myTable").dataTable({
            "bServerSide": true,
            "sAjaxSource": config.ajaxUrls.communityGetAll,
            "bInfo":true,
            "bProcessing":true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort":false,
            "bAutoWidth": false,
            "iDisplayLength":config.perLoadCounts.table,
            "sPaginationType":"full_numbers",
            "oLanguage": {
                "sUrl":config.dataTable.langUrl
            },
            "aoColumns": [
                { "mDataProp": "community_title"},
                { "mDataProp": "create_at"},
                { "mDataProp": "opt",
                    "fnRender":function(oObj){
                        return '<a class="check" href="'+oObj.aData.community_id+'">查看</a>&nbsp;' +
                            '<a class="delete" href="'+oObj.aData.community_id+'">删除</a>';
                    }
                }
            ] ,
            "fnServerParams": function ( aoData ) {

            },
            "fnServerData": function(sSource, aoData, fnCallback) {

                //回调函数
                $.ajax({
                    "dataType":'json',
                    "type":"get",
                    "url":sSource,
                    "data":aoData,
                    "success": function (response) {
                        if(response.success===false){
                            functions.ajaxReturnErrorHandler(response.error_code);
                        }else{
                            var json = {
                                "sEcho" : response.sEcho
                            };

                            for (var i = 0, iLen = response.aaData.length; i < iLen; i++) {
                                loadedData[response.aaData[i].community_id]=response.aaData[i];
                                response.aaData[i].opt="opt";
                            }

                            json.aaData=response.aaData;
                            json.iTotalRecords = response.iTotalRecords;
                            json.iTotalDisplayRecords = response.iTotalDisplayRecords;
                            fnCallback(json);
                        }

                    }
                });
            },
            "fnFormatNumber":function(iIn){
                return iIn;
            }
        });

        return ownTable;
    }

    return {
        ownTable:null,
        createTable:function(){
            this.ownTable=createTable();
        },
        tableRedraw:function(){
            this.ownTable.fnSettings()._iDisplayStart=0;
            this.ownTable.fnDraw();
        },
        delete:function(id){
            functions.showLoading();
            var me=this;
            $.ajax({
                url:config.ajaxUrls.communityDelete+"?id="+id,
                type:"post",
                dataType:"json",
                success:function(response){
                    if(response.success){
                        $().toastmessage("showSuccessToast",config.messages.optSuccess);
                        me.ownTable.fnDraw();
                        functions.hideLoading();
                    }else{
                        functions.ajaxReturnErrorHandler(response.error_code);
                    }

                },
                error:function(){
                    functions.ajaxErrorHandler();
                }
            });
        },
        check:function(id){
            $("#name").text(loadedData[id].community_title);
            $("#content").html(loadedData[id].community_content);
            $("#checkModel").modal("show");
        }
    }
})(config,functions);

$(document).ready(function(){

    communityMgr.createTable();

    $("#myTable").on("click","a.delete",function(){
        if(confirm(config.messages.confirmDelete)){
            communityMgr.delete($(this).attr("href"));
        }
        return false;
    }).on("click","a.check",function(){
            communityMgr.check($(this).attr("href"));
            return false;
        });
});

