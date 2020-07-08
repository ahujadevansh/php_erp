$(function(){
    $("#add-product").validate({
        rules: {
            'product_id':{
                required: true,
            },
            'eoq_level':{
                required: true,
                min: 0,
            },
            'danger_level':{
                required: true,
                min: 0,
            },
            'quantity':{
                required: true,
                min: 0,
            },
        },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });
});
