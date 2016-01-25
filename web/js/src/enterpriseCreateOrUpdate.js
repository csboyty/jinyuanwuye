var enterpriseCreateOrUpdate=(function(config,functions){
    return{
        submitForm:function(form){
            var me=this;
            functions.showLoading();
            $(form).ajaxSubmit({
                dataType:"json",
                success:function(response){
                    if(response.success){
                        $().toastmessage("showSuccessToast",config.messages.optSuccess);
                        setTimeout(function(){
                            window.location.href="enterprise/index";
                        },3000);
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
    $("#myForm").validate({
        ignore:[],
        rules:{
            enterprise_name:{
                required:true,
                maxlength:32
            },
            create_at:{
                required:true
            }
        },
        messages:{
            enterprise_name:{
                required:config.validErrors.required,
                maxlength:config.validErrors.maxLength.replace("${max}",32)
            },
            create_at:{
                required:config.validErrors.required
            }
        },
        submitHandler:function(form) {
            enterpriseCreateOrUpdate.submitForm(form);
        }
    });
});
