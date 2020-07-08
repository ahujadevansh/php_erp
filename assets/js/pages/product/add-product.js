$(function(){
    $("#add-product").validate({
        rules: {
            'name':{
                required: true,
                minlength: 2,
                maxlength: 255
            },
            'specification':{
                required: false
            },
            'hsn_code':{
                required: true,
            },
            'brand_id':{
                required: true,
            },
            'category_id':{
                required: true,
            },
            'supplier_id':{
                required:true
            },
            'selling_rate':{
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
