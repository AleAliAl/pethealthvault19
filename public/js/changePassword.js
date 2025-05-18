$('#change_password_form').validate({
    ignore:'.ignore',
    errorClass:'invalid',
    validClass:'success',
    rules:{
         old_password:{
            required:true,
            minlength:6,
            maxlength:100
         },
         new_password:{
            required:true,
            minlength:6,
            maxlength:100
         },
         confirm_password:{
            required:true,
            equalTo:'#new_password'
         },
    },
     messages: {
     
        old_password:{
            required:"Enter your old password"
        },
        new_password:{
            required:"Enter your new password"
        },
        confirm_password:{
            required:"Need to confirm your new password"
        },

     },
     submitHandler:function(form){
        $.LoadingOverlay("show");
        form.submit();
     }

});