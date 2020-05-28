var id=2;

function deleteProduct(delete_id) {
    var elements = document.getElementsByClassName("product_row");
    if(elements.length > 1) {
        $("#element_"+delete_id).remove();
    }
}

function addProduct() {
    $("#products_container").append(

        `<!-- BEGIN: PRODUCT CUSTOM CONTROL -->
        <div class="row product_row" id="element_${id}">
          <!-- BEGIN: CATEGORY SELECT -->
          <div class="col-md-2">
              <div class="form-group">
                  <label for="category_${id}">Category</label>
                  <select id="category_${id}" class="form-control">
                      <option disabled selected>Select Category</option>
                      <?php
                      $categories = $di->get('database')->readData("category", ["id", "name"], "deleted=0");
                      foreach($categories as $category){
                          echo"<option value='{$category->id}'>{$category->name}</option>";
                      }
                      ?>
                  </select>
              </div>
          </div>
          <!-- END: CATEGORY SELECT -->
          <!-- BEGIN: PRODUCT SELECT -->
          <div class="col-md-3">
              <div class="form-group">
                  <label for="product_${id}">Products</label>
                  <select name="product_id[]" id="product_${id}" class="form-control">
                      <option disabled selected>Select Product</option>
                  </select>
              </div>
          </div>
          <!-- END: PRODUCT SELECT -->
          <!-- BEGIN: Quantity -->
              <div class="col-md-2">
                  <div class="form-group">
                      <label for="quantity_${id}">Quantity</label>
                      <input type="number" name="quantity[]" id="quantity_${id}" class="form-control" placeholder="Enter Quantity">
                  </div>
              </div>
          <!-- END: Quantity -->
          <!-- BEGIN: Discount -->
          <div class="col-md-2">
              <div class="form-group">
                  <label for="discount_${id}">Discount</label>
                  <input type="text" name="discount[]" id="discount_${id}" class="form-control" placeholder="Enter Discount">
              </div>
          </div>
          <!-- END: Discount -->
          <!-- BEGIN: Selling Price -->
          <div class="col-md-2">
              <div class="form-group">
                  <label for="selling_price_${id}">Selling Price</label>
                  <input type="text" id="selling_price_${id}" class="form-control" disabled>
              </div>
          </div>
          <!-- END:  Selling Price -->
          <!-- BEGIN: DELETE BUTTON -->
          <div class="col-md-1">
              <button onclick="deleteProduct(${id})" type="button" class="btn btn-danger" style="margin-top: 40%;">
                  <i class="fas fa-trash-alt"></i>
              </button>

          </div>
          <!-- END:  DELETE BUTTON -->
    </div>
    <!-- BEGIN: PRODUCT CUSTOM CONTROL -->
        `

    );

   /* var baseURL = window.location.origin;
    var filePath = "/helper/routing.php"
    $.ajax({
        url: baseURL+filePath,
        method: 'POST',
        data: {
            getCategories: true,
        },
        dataType: 'json',
    });*/

    id++;
}


