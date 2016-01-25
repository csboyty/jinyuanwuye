var serviceMgr=(function(config,functions){
    var loadedData={};
    /**
     * 创建datatable
     * @returns {*|jQuery}
     */
    function createTable(){

        var ownTable=$("#myTable").dataTable({
            "bServerSide": true,
            "sAjaxSource": config.ajaxUrls.serviceGetAll,
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
                { "mDataProp": "user_name"},
                { "mDataProp": "tel"},
                { "mDataProp": "remark"},
                { "mDataProp": "create_at"},
                { "mDataProp": "status",
                    "fnRender":function(oObj){
                        return config.status.service[oObj.aData.status];
                    }},
                { "mDataProp": "opt",
                    "fnRender":function(oObj){
                        return '<a class="check" href="'+oObj.aData.service_id+'">查看</a>&nbsp;';
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
                                response.aaData[i].user_name=response.aaData[i].user.name;
                                loadedData[response.aaData[i].service_id]=response.aaData[i];
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
        check:function(id){
            var data=loadedData[id];
            $("#serviceId").val(id);
            $("#name").text(data.user_name);
            $("#remark").html(data.remark);
            $("#address").text(data.address);
            $("#tel").text(data.tel);
            $("#status").text(config.status.service[data.status]);
            $("#createDate").text(data.create_at);
            $("#handleDate").text(data.handle_at);
            $("#feedback").text(data.feedback);

            if(data.status==0){
                $("#submitBtnRow").removeClass("hidden");
            }else{
                $("#submitBtnRow").addClass("hidden");
            }
            $("#checkModel").modal("show");
        },
        handle:function(form){
            var me=this;
            functions.showLoading();
            $(form).ajaxSubmit({
                dataType:"json",
                success:function(response){
                    if(response.success){
                        functions.hideLoading();
                        $().toastmessage("showSuccessToast",config.messages.optSuccess);
                        $("#checkModel").modal("hide");
                        me.ownTable.fnDraw();
                        $(form)[0].reset();
                    }else{
                        functions.ajaxReturnErrorHandler(response.error_code);
                    }
                },
                error:function(){
                    functions.ajaxErrorHandler();
                }
            });
        }
    }
})(config,functions);

$(document).ready(function(){

    serviceMgr.createTable();

    $("#myTable").on("click","a.check",function(){
            serviceMgr.check($(this).attr("href"));
            return false;
        });

    $("#myForm").validate({
        ignore:[],
        rules: {
            feedback: {
                required:true,
                maxlength:500
            }
        },
        messages: {
            feedback: {
                required:config.validErrors.required,
                maxlength:config.validErrors.maxLength.replace("${max}",500)
            }
        },
        submitHandler:function(form) {
            serviceMgr.handle(form);
        }
    });
});

