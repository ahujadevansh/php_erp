<?php
    require_once(__DIR__ . "/../../helper/init.php" );
    $sidebarSection = 'customer';
    $sidebarSubSection = 'add_customer' ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
  $title = 'Easy ERP';
?>
<?php require_once(__DIR__ . "/../includes/head-section.php") ?>
  <!-- Place Custom CSS File -->
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
            <h1 class="h3 mb-0 text-gray-800">Customer</h1>
            <a href="<?= BASEPAGES; ?>manage-customer.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Customer
            </a>
          </div>

          <div class="row">

            <div class="col-lg-12">

              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Add Customer</h6>
                </div>
                <div class="card-body">
                  <div class="col-md-12">

                    <form action="<?=BASEURL;?>helper/routing.php" method="POST" id="add-customer">

                    </form>

                  </div>
                </div>
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


</body>

</html>
