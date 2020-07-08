<?php
require_once(__DIR__ . "/../../helper/init.php" );
$sidebarSection = 'product';
$sidebarSubSection = 'add_product' ;
$title = "Easy ERP | Add Product";
Util::createCSRFToken();
$errors = "";
if(Session::hasSession('errors'))
{
  $errors = unserialize(Session::getSession('errors'));
  Session::unsetSession('errors');
}
$old = "";
if(Session::hasSession('old'))
{
  $old = Session::getSession('old');
  Session::unsetSession('old');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once(__DIR__ . "/../includes/head-section.php") ?>
  <!--PLACE TO ADD YOUR CUSTOM CSS-->
  <link href="<?= BASEASSETS?>css/form.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php require_once(__DIR__ . "/../includes/sidebar.php") ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php require_once(__DIR__ . "/../includes/navbar.php") ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Product</h1>
            <a href="<?= BASEPAGES; ?>manage-product.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Product
            </a>
          </div>

          <div class="row">

            <div class="col-lg-12">

              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                </div>
                <form id="add-product" action="<?=BASEURL;?>helper/routing.php" method="POST">
                  <div class="card-body">
                    <div class="col-md-12">
                      <input type="hidden" name="csrf_token" value="<?=Session::getSession('csrf_token');?>">
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="name">Product Name<span class="required">*</span></label>
                          <input type="text" name="name" id="name"
                            class="form-control <?= $errors != '' && $errors->has('name') ? 'error' : ''; ?>"
                            placeholder="Enter Product Name" value="<?= $old != '' && isset($old['name']) ? $old['name'] : ''; ?>"
                            required>
<?php
if ($errors != "" && $errors->has('name')) {
  echo "<span class='error'>{$errors->first('name')}</span>";
}
?>
                        </div>
                        <div class="form-group col-6">
                          <label for="specification">Specifications</label>
                          <input type="text" name="specification" id="specification"
                            class="form-control <?= $errors != '' && $errors->has('specification') ? 'error' : ''; ?>"
                            value="<?= $old != '' && isset($old['specification']) ? $old['specification'] : ''; ?>"
                            placeholder="Enter Product Specifications"/>
<?php
if ($errors != "" && $errors->has('specification')) {
    echo "<span class='error'>{$errors->first('specification')}</span>";
}
?>
                        </div>
                      </div>
                      <div class="row">
                        <!--CATEGORY-->
                        <div class="form-group col-4">
                            <label for="category_id">Category<span class="required">*</span></label>
                          <select name="category_id" id="category_id" class="form-control" required>
                              <option disabled selected>Select....</option>
<?php
$categories = $di->get('database')->readData('category', ["id", "name"], "deleted=0");

foreach ($categories as $category) {

    if($old != '' && isset($old['category_id']) && $category->id == $old['category_id'])
        echo "<option value='{$category->id}' selected>{$category->name}</option>";
    else
        echo "<option value='{$category->id}'>{$category->name}</option>";
}
if ($errors != "" && $errors->has('category_id')) {
    echo "<span class='error'>{$errors->first('category')}</span>";
}
?>
                          </select>
                        </div>
                        <!--/CATEGORY-->
                        <!--BRAND-->
                        <div class="form-group col-4">
                          <label for="brand_id">Brand<span class="required">*</span></label>
                          <select name="brand_id" id="brand_id" class="form-control" required>
                              <option disabled selected>Select....</option>
<?php
$brands = $di->get('database')->readData('brands', ["id", "name"], "deleted=0");

foreach ($brands as $brand) {
    if($old != '' && isset($old['brand_id']) && $brand->id === $old['brand_id'])
        echo "<option value='{$brand->id}' selected>{$brand->name}</option>";
    else
        echo "<option value='{$brand->id}'>{$brand->name}</option>";
}
if ($errors != "" && $errors->has('brand_id')) {
    echo "<span class='error'>{$errors->first('brand')}</span>";
}
?>
                          </select>
                        </div>
                        <!--/BRAND-->
                        <!--HSN CODE-->
                        <div class="form-group col-4">
                          <label for="hsn_code">HSN Code<span class="required">*</span></label>
                          <select name="hsn_code" id="hsn_code" class="form-control" required>
                            <option disabled selected>Select....</option>
<?php
$hsn_codes = $di->get('database')->raw("SELECT DISTINCT `hsn_code` FROM `gst`;");

foreach ($hsn_codes as $hsn_code) {
    if($old != '' && isset($old['hsn_code']) && $hsn_code->hsn_code === $old['hsn_code'])
        echo "<option value='{$hsn_code->hsn_code}' selected>{$hsn_code->hsn_code}</option>";
    else
        echo "<option value='{$hsn_code->hsn_code}'>{$hsn_code->hsn_code}</option>";
}
if ($errors != "" && $errors->has('hsn_code')) {
    echo "<span class='error'>{$errors->first('hsn_code')}</span>";
}
?>
                          </select>
                        </div>
                        <!--/HSN CODE-->

                    </div>
                    <div class="row">
                        <!--SUPPLIERS-->
                        <div class="form-group col-6">
                          <label for="email_id">Suppliers<span class="required">*</span></label>
                          <select name="supplier_id[]" id="supplier_id" class="form-control" required multiple>
<?php
$suppliers = $di->get('database')->readData('suppliers', ["id", "first_name", "last_name"], "deleted=0");

foreach ($suppliers as $supplier) {
    echo "<option value='{$supplier->id}'>{$supplier->first_name} {$supplier->last_name}</option>";
}
?>
                         </select>
                        </div>
                        <!--/SUPPLIERS-->
                        <!--SELLING RATE-->
                        <div class="form-group col-6">
                        <label for="selling_rate">Selling Rate<span class="required">*</span></label>
                        <input type="number" name="selling_rate" id="selling_rate"
                            class="form-control <?= $errors != '' && $errors->has('selling_rate') ? 'error' : ''; ?>"
                            value="<?= $old != '' && isset($old['selling_rate']) ? $old['selling_rate'] : ''; ?>"
                            placeholder="Enter Product Selling Rate"  required/>
<?php
if ($errors != "" && $errors->has('selling_rate')) {
  echo "<span class='error'>{$errors->first('selling_rate')}</span>";
}
?>
                        </div>
                        <!--/SELLING RATE-->
                    </div>
                    </div>
                  </div>
                  <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mb-3" name="page" value="add_Product"><i class="fa fa-check"></i>&nbsp; Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


    <?php require_once(__DIR__ . "/../includes/footer.php") ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


<?php require_once(__DIR__ . "/../includes/scroll-to-top.php") ?>




<?php require_once(__DIR__ . "/../includes/core-scripts.php") ?>

<!--PAGE LEVEL SCRIPTS-->
<?php require_once(__DIR__ . "/../includes/page-level/product/add-product-scripts.php") ?>

</body>

</html>
