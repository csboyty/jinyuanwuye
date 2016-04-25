var userCreateOrUpdate=(function(config,functions){
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
                            window.location.href="user/index";
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
    $('#myTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show')
    });

    $("#myForm").validate({
        ignore:[],
        rules: {
            name: {
                required:true,
                maxlength:30
            },
            password:{
                required:true,
                rangelength:[6, 120]
            }
        },
        messages: {
            name: {
                required:config.validErrors.required,
                maxlength:config.validErrors.maxLength.replace("${max}",30)
            },
            password:{
                required:config.validErrors.required,
                rangelength:config.validErrors.rangLength.replace("${min}",6).replace("${max}",20)
            }
        },
        submitHandler:function(form) {
            userCreateOrUpdate.submitForm(form);
        }
    });
    $("#myFormPWD").validate({
        ignore:[],
        rules: {
            password:{
                required:true,
                rangelength:[6, 20]
            }
        },
        messages: {
            password:{
                required:config.validErrors.required,
                rangelength:config.validErrors.rangLength.replace("${min}",6).replace("${max}",20)
            }
        },
        submitHandler:function(form) {
            userCreateOrUpdate.submitForm(form);
        }
    });
});
