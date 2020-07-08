$(function(){
    $("#employee-signin").validate({
        rules: {
            'email':{
                required: true,
                email: true,
                minlength: 2,
                maxlength: 255
            },
            'password':{
                minlength: 8
            }
        },
        messages: {
            email: {
              required: "We need your email address to contact you",
              email: "Your email address must be in the format of name@domain.com"
            }
          },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });
});
