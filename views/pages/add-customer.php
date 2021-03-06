<?php
    require_once(__DIR__ . "/../../helper/init.php" );
    $title = 'Easy ERP';
    $sidebarSection = 'customer';
    $sidebarSubSection = 'add_customer';
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
        <!-- Place Custom CSS File -->
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
                                    <form action="<?=BASEURL;?>helper/routing.php" method="POST" id="add-customer" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">
                                                <div class="form-group">
                                                    <label class="text-dark" for="email">Email<span class="required">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
<?php
  if($errors!="" && $errors->has('email'))
  {
    echo "<span class='error'>{$errors->first('email')}</span>";
  }
?>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-6">
                                                        <label class="text-dark" for="first_name">First Name<span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name">
<?php
  if($errors!="" && $errors->has('first_name'))
  {
    echo "<span class='error'>{$errors->first('first_name')}</span>";
  }
?>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6">
                                                        <label class="text-dark" for="last_name">Last Name<span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name">

<?php
  if($errors!="" && $errors->has('last_name'))
  {
    echo "<span class='error'>{$errors->first('last_name')}</span>";
  }
?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="about" class="text-dark">About</label>
                                                    <textarea name="about" id="about" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone" class="text-dark">Phone Number</label>
                                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone Number">

<?php
  if($errors!="" && $errors->has('phone'))
  {
    echo "<span class='error'>{$errors->first('phone')}</span>";
  }
?>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-6">
                                                    <label for="gender" class="text-dark">Gender</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                        <option value="O">Other</option>
                                                    </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6">
                                                    <label for="gender" class="text-dark">Date of birth</label>
                                                    <input type="date" class="form-control" id="birthdate" name="birthdate">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image" class="text-dark">Profile Photo</label>
                                                    <input type="file" class="form-control-file border" id="image" name="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mb-3" name="page" value="add_customer">Add <i class="fa fa-user-plus px-1"></i></button>
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


    </body>

</html>
