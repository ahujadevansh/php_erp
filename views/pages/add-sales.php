<?php
require_once __DIR__ . '/../../helper/init.php';
$title = "Easy ERP | Add Sales";
$sidebarSection = "transaction";
$sidebarSubSection = "sales";
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
  <?php
  require_once __DIR__ . "/../includes/head-section.php";
  ?>
  <style>
      .email-verify {
          background: green;
          color: #FFF;
          padding: 5px 10px;
          font-size: .875;
          line-height: 1.5;
          border-radius: .2rem;
          vertical-align: middle;
      }
  </style>

  <!--PLACE TO ADD YOUR CUSTOM CSS-->
  <link href="<?= BASEASSETS?>css/form.css" rel="stylesheet">
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once(__DIR__ . "/../includes/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once(__DIR__ . "/../includes/navbar.php"); ?>
        <!-- .container-fluid -->
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sales</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Sales
            </a>
          </div>



          <div class="row">
            <div class="col-lg-12">

              <!-- BEGIN: Basic Card -->
              <div class="card shadow mb-4">
                <div class="card-header py-3 px-2">
                    <div class="d-flex flex-row justify-content-end">
                        <div class="mr-3">
                            <input type="text" class="form-control" name="email" id="customer_email" placeholder="Enter email of customer">
<?php
if ($errors != "" && $errors->has('customer_id')) {
    echo "<span class='error'>{$errors->first('customer_id')}</span>";
}
?>
                        </div>
                        <button type="button" class="d-sm-inline-block btn btn-primary shadow-sm" name="check_email" id="check_email">
                            <i class="fas fa-envelope fa-sm text-white" aria-hidden="true"></i> Check Email
                        </button>
                        <p class="email-verify d-none" id="email_verify_success">
                            <i class="fas fa-check fa-sm text-white"></i> Email Verified
                        </p>
                    </div>
                    <div class="py-2 d-flex flex-row justify-content-end">
                        <p class="email-verify bg-danger d-none mb-0 mx-1" id="email_verify_fail">
                            <i class="fas fa-times fa-sm text-white mr-1"></i>Email Not Verified
                        </p>
                        <a href="<?= BASEPAGES; ?>add-customer.php" class="btn btn-warning shadow-sm d-none mx-1" id="add_customer_btn">
                            <i class="fas fa-plus fa-sm text-white" aria-hidden="true"></i> Add Customer
                        </a>
                    </div>
                </div>
                <div class="card-header py-3 d-flex flex-row justify-content-between align-items-end">
                  <h6 class="m-0 font-weight-bold text-primary">Add Sales</h6>
                  <button type="button"
                  onclick="addProduct();"
                  class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm">

                    <i class="fas fa-plus fa-sm text-white"></i>Add one More Product

                  </button>
                </div>


                    <form id="add-sales" action="<?=BASEURL;?>helper/routing.php" method="POST">
                      <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">
                      <input type="hidden" name="customer_id" id="customer_id">
                      <div class="card-body">
                        <div class="py-2" id="products_container">
                            <!-- PRODUCT ROW FROM js -->
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="row">
                            <div class="form-group col-md-10 d-flex justify-content-end">
                                <div class="form-inline">
                                    <label class="my-1 mr-2" for="final_total">Final Total</label>
                                    <input type="number" class="form-control" id="final_total" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block" name="page" value="add_sales"><i class="fa fa-check"></i> Sale</button>
                            </div>
                        </div>
                      </div>
                    </form>
              </div>
              <!--END: Basic Card -->
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
      <?php require_once(__DIR__ . "/../includes/footer.php"); ?>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <?php
  require_once(__DIR__ . "/../includes/scroll-to-top.php");
  ?>
  <?php require_once(__DIR__ . "/../includes/core-scripts.php"); ?>

  <!--PAGE LEVEL SCRIPTS-->
  <?php require_once(__DIR__ . "/../includes/page-level/transactions/add-sales-scripts.php");?>
</body>

</html>
