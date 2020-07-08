$(function(){
    $("#add-category").validate({
        rules: {
            'name':{
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'description':{
                required: false
            }
        },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });
});
