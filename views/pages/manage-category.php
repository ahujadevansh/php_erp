<?php
require_once __DIR__ . '/../../helper/init.php';
$title = "Easy ERP | Manage Category";
$sidebarSection = "category";
$sidebarSubSection = "manage_category";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php  require_once __DIR__ . "/../includes/head-section.php"; ?>
  <!--PLACE TO ADD YOUR CUSTOM CSS-->
  <link rel="stylesheet" href="<?=BASEASSETS;?>vendor/toastr/toastr.min.css">

  <!-- Custom styles for this page -->
  <link href="<?=BASEASSETS;?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once(__DIR__. "/../includes/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once(__DIR__. "/../includes/navbar.php");?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category</h1>
            <a href="<?= BASEPAGES;?>add-category.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fa fa-plus fa-sm text-white-75"></i> Add Category
            </a>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Manage Categories</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="manage-category-datatable" class="table table-striped table-hover table-bordered dataTable">
                  <thead class="thead-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once(__DIR__. "/../includes/footer.php");?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->


  <?php
  require_once(__DIR__ . "/../includes/scroll-to-top.php");
  ?>
  <?php require_once(__DIR__."/../includes/core-scripts.php");?>
  <!--PAGE LEVEL SCRIPTS-->
  <?php require_once(__DIR__."/../includes/page-level/category/manage-category-scripts.php");?>


</body>

</html>
