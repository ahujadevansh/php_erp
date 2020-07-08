var id=1;
var baseURL = window.location.origin;
var filePath = "/helper/routing.php"


$(document).ready(
    addProduct()
);

$(function() {
    $("#add-sales").validate({
        rules: {
            'product_id[]':{
                required: true,
            },
            'quantity[]':{
                required: true,
                min: 1,
            },
            'discount[]':{
                required: true,
                min: 0,
                max:100,
            },
        },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });
});

function addProduct() {
    $("#products_container").append(

       `<!-- BEGIN: PRODUCT CUSTOM CONTROL -->
        <div class="row product_row border-bottom-secondary my-2 align-items-center h-100" id="element_${id}">
          <div class="col-md-10 row">
            <!-- BEGIN: CATEGORY SELECT -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="category_${id}">Category</label>
                    <select id="category_${id}" class="form-control category_select">
                        <option disabled selected>Select Category</option>
                    </select>
                </div>
            </div>
            <!-- END: CATEGORY SELECT -->
            <!-- BEGIN: Brand SELECT -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="brand_${id}">Brand</label>
                    <select id="brand_${id}" class="form-control brand_select">
                        <option disabled selected>Select Brand</option>
                    </select>
                </div>
            </div>
            <!-- END: Brand SELECT -->
            <!-- BEGIN: PRODUCT SELECT -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="product_${id}">Products</label>
                    <select name="product_id[]" id="product_${id}" class="form-control product_select">
                        <option disabled selected>Select Product</option>
                    </select>
                </div>
            </div>
            <!-- END: PRODUCT SELECT -->
            <!-- BEGIN: Quantity -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="quantity_${id}">Quantity</label>
                    <input type="number" name="quantity[]" id="quantity_${id}" class="form-control quantity_input" value="1" min="1" disabled>
                </div>
            </div>
            <!-- END: Quantity -->
            <!-- BEGIN: Discount -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="discount_${id}">Discount(%)</label>
                    <input type="number" name="discount[]" id="discount_${id}" class="form-control discount_input" value="0" max="100" min="0" disabled>
                </div>
            </div>
            <!-- END: Discount -->
            <!-- BEGIN: Selling Price -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="selling_rate_${id}">Rate</label>
                    <input type="number" id="selling_rate_${id}" class="form-control" value="0" disabled>
                </div>
            </div>
            <!-- END:  Selling Price -->
            <!-- BEGIN: Total -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="total${id}">Total</label>
                    <input type="number" id="total_${id}" class="form-control" value="0" disabled>
                </div>
            </div>
            <!-- END:  Total -->
          </div>
          <!-- BEGIN: DELETE BUTTON -->
          <div class="col-md-2 mx-auto mb-2">
              <button onclick="deleteProduct(${id})" type="button" class="btn btn-danger btn-block">
                  <i class="fas fa-trash-alt"></i> Delete
              </button>
          </div>
          <!-- END:  DELETE BUTTON -->
        </div>
        <!-- END: PRODUCT CUSTOM CONTROL -->
        `

    );

    let csrf_token = $("[name='csrf_token']").val();
    $.ajax({
        url: baseURL+filePath,
        method: 'POST',
        data: {
            "csrf_token": csrf_token,
            'fetch': 'getAllCategories',
        },
        dataType: 'json',
        success : function(categories) {
            categories.forEach(function (category) {
                $("#category_"+id).append(
                    `<option value='${category.id}'>${category.name}</option>`
                );
            });
        }
    });

    $.ajax({
        url: baseURL+filePath,
        method: 'POST',
        data: {
            "csrf_token": csrf_token,
            'fetch': 'getAllBrands',
        },
        dataType: 'json',
        success : function(brands) {
            brands.forEach(function (brand) {
                $("#brand_"+id).append(
                    `<option value='${brand.id}'>${brand.name}</option>`
                );
            });
            id ++;
        }
    });
}

function deleteProduct(id) {
    let elements = document.getElementsByClassName("product_row");
    if(elements.length > 1) {
        let finaltotal = (parseFloat($('#final_total').val()) - $('#total_'+id).val()).toFixed(2);
        $('#final_total').val(finaltotal);
        $("#element_"+id).remove();
    }
}

$('#check_email').on('click', function() {

    let email = $('#customer_email').val();
    let csrf_token = $("[name='csrf_token']").val();
    $.ajax({
        url: baseURL+filePath,
        method: "POST",
        dataType: 'json',
        data: {
            "csrf_token": csrf_token,
            "email": email,
            "fetch": 'getCustomerFromEmail'
        },
        success: function(customer) {
            console.log(customer);
            if(customer) {
                $('#email_verify_success').removeClass('d-none');
                $('#email_verify_success').addClass('d-inline-block');
                $('#check_email').remove();
                $('#customer_email').prop('disabled', true);
                $('#customer_id').val(customer['id']);
                $('#email_verify_fail').addClass('d-none');
                $('#email_verify_fail').removeClass('d-inline-block');
                $('#add_customer_btn').addClass('d-none');
                $('#add_customer_btn').removeClass('d-inline-block');
            }
            else {
                $('#email_verify_fail').removeClass('d-none');
                $('#email_verify_fail').addClass('d-inline-block');
                $('#add_customer_btn').removeClass('d-none');
                $('#add_customer_btn').addClass('d-inline-block');
            }
        }
    });
});

$('#products_container').on('change', '.category_select, .brand_select', function() {

    let id = $(this).attr('id').split("_")[1];
    let category = $("#category_"+id).val();
    let brand = $("#brand_"+id).val();
    let csrf_token = $("[name='csrf_token']").val();
    $.ajax({
        url: baseURL+filePath,
        method: 'POST',
        data: {
            "csrf_token": csrf_token,
            'brand_id': brand,
            'category_id': category,
            'fetch': 'filterProductByCategory',
        },
        dataType: 'json',
        success : function(products) {
            $("#product_"+id).empty();
            $("#product_"+id).append(
                '<option disabled selected>Select Product</option>'
            );
            products.forEach(function (product) {
                $("#product_"+id).append(
                    `<option value='${product.id}'>${product.name}</option>`
                );
            });
            id ++;
        }
    });
});

$('#products_container').on('change', '.product_select', function() {

    let id = $(this).attr('id').split("_")[1];
    let product = $(this).val();
    let csrf_token = $("[name='csrf_token']").val();
    $.ajax({

        url: baseURL+filePath,
        method: 'POST',
        dataType: 'json',
        data: {
            "csrf_token": csrf_token,
            'product_id': product,
            'fetch': 'getSellingRateByProduct',
        },
        success: function(products) {
            $('#quantity_'+id).prop('disabled', false);
            $('#discount_'+id).prop('disabled', false);
            let quantity = $('#quantity_'+id).val();
            let discount = $('#discount_'+id).val();
            let selling_rate = products[0]['selling_rate'];
            $('#selling_rate_'+id).val(selling_rate);
            let old_total = $('#total_'+id).val();
            let new_total = (selling_rate - (selling_rate*discount*0.01))*quantity;
            $('#total_'+id).val(new_total);
            let finaltotal = (parseFloat($('#final_total').val()) - old_total + new_total).toFixed(2);
            $('#final_total').val(finaltotal);
        },
    });
});

$('#products_container').on('change', '.quantity_input, .discount_input', function() {

    let id = $(this).attr('id').split("_")[1];
    let selling_rate = $('#selling_rate_'+id).val();
    let quantity = $('#quantity_'+id).val();
    let discount = $('#discount_'+id).val();
    let old_total = $('#total_'+id).val();
    let new_total = (selling_rate - (selling_rate*discount*0.01))*quantity;
    let finaltotal = (parseFloat($('#final_total').val()) - old_total + new_total).toFixed(2);
    $('#total_'+id).val(new_total);
    $('#final_total').val(finaltotal);
});


