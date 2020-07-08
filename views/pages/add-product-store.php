<?php
require_once(__DIR__ . "/../../helper/init.php" );

$di->get('auth')->loginRequired();

$sidebarSection = 'product';
$sidebarSubSection = 'add_product_store' ;
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

                <form id="add-product-store" action="<?=BASEURL;?>helper/routing.php" method="POST">
                  <div class="card-body">
                    <div class="col-md-12">
                      <input type="hidden" name="csrf_token" value="<?=Session::getSession('csrf_token');?>">
                        <!--Product Name-->
                        <div class="form-group">
                          <label for="product_id">Product Name<span class="required">*</span></label>
                          <select name="product_id" id="product_id" class="form-control" required>
                              <option disabled selected>Select Product....</option>
<?php
$products = $di->get('database')->readData('products', ["id", "name"], "deleted=0");

foreach ($products as $product) {

    if($old != '' && isset($old['product_id']) && $category->id == $old['product_id'])
        echo "<option value='{$product->id}' selected>{$product->name}</option>";
    else
        echo "<option value='{$product->id}'>{$product->name}</option>";
}
if ($errors != "" && $errors->has('product_id')) {
    echo "<span class='error'>{$errors->first('category')}</span>";
}
?>
                          </select>
                        </div>
                        <!--/Product Name-->
                      <div class="row">
                        <!--QUANTITY-->
                        <div class="form-group col-4">
                        <label for="quantity">Quantity</label>
                        <input type="text" name="quantity" id="quantity" class="form-control <?= $errors != '' && $errors->has('quantity') ? 'error' : ''; ?>" placeholder="Enter Product Quantity" value="<?= $old != '' && isset($old['quantity']) ? $old['quantity'] : ''; ?>" />
    <?php
    if ($errors != "" && $errors->has('quantity')) {
    echo "<span class='error'>{$errors->first('quantity')}</span>";
    }
    ?>
                        </div>
                        <!--/QUANTITY-->
                        <!--EOQ Level-->
                        <div class="form-group col-4">
                            <label for="eoq_level">EOQ Level</label>
                            <input type="text" name="eoq_level" id="eoq_level" class="form-control <?= $errors != '' && $errors->has('eoq_level') ? 'error' : ''; ?>" placeholder="Enter Product EOQ Level" value="<?= $old != '' && isset($old['eoq_level']) ? $old['eoq_level'] : ''; ?>" />
    <?php
    if ($errors != "" && $errors->has('eoq_level')) {
        echo "<span class='error'>{$errors->first('eoq_level')}</span>";
    }
    ?>
                        </div>
                        <!--/EOQ Level-->
                        <!--Danger Level-->
                        <div class="form-group col-4">
                        <label for="danger_level">Danger Level</label>
                        <input type="text" name="danger_level" id="danger_level" class="form-control <?= $errors != '' && $errors->has('danger_level') ? 'error' : ''; ?>" placeholder="Enter Product Danger Level" value="<?= $old != '' && isset($old['danger_level']) ? $old['danger_level'] : ''; ?>" />
    <?php
    if ($errors != "" && $errors->has('danger_level')) {
        echo "<span class='error'>{$errors->first('danger_level')}</span>";
    }
    ?>
                        </div>
                        <!--/Danger Level-->
                      </div>
                    </div>
                  </div>
                  <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mb-3" name="page" value="add_Product_store"><i class="fa fa-check"></i>&nbsp; Submit</button>
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
<?php require_once(__DIR__ . "/../includes/page-level/product/add-product-store-scripts.php") ?>

</body>

</html>
