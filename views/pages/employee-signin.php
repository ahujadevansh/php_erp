<?php

require_once __DIR__ . '/../../helper/init.php';
$title = "Easy ERP | Employee Sign In";
$sidebarSection = "";
$sidebarSubSection = "";
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
if($di->get('auth')->check()) {
    Util::redirect('index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once(__DIR__ . "/../includes/head-section.php") ?>
  <!--PLACE TO ADD YOUR CUSTOM CSS-->
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
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" id="employee-signin" action="<?= BASEURL?>helper/routing.php" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" id="email" value="<?=$old != '' && isset($old['email']) ?$old['email']: '';?>" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        <div class="email_error"> </div>
<?php
  if($errors!="" && $errors->has('email'))
  {
    echo "<span class='error'>{$errors->first('email')}</span>";
  }
?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                                        <div class="password_error"> </div>
<?php
  if($errors!="" && $errors->has('password'))
  {
    echo "<span class='error'>{$errors->first('password')}</span>";
  }
?>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me" checked>
                                        <label class="custom-control-label" for="remember_me">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" name="page" value="employee_sign_in">
                                        Sign In
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= BASEPAGES?>employee-forget-password.php">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register.html">Create an Account!</a>
                                </div>
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

<!-- Place your page level scripts here -->
<?php require_once(__DIR__ . "/../includes/page-level/auth/employee-signin-scripts.php") ?>


</body>

</html>
