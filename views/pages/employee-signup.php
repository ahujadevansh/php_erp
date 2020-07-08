<?php

require_once __DIR__ . '/../../helper/init.php';
$title = "Easy ERP | Employee Sign Up";
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
            <form class="m-2" action="<?= BASEURL?>helper/routing.php" method="POST">

                <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">
                <fieldset>
                    <legend>Sign In</legend>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?=$old != '' && isset($old['name']) ?$old['name']: '';?>">
                        <div class="email_error"> </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <div class="password_error"> </div>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="remember_me" name="remember_me" checked>
                        <label for="remember">Remember Me</label>

                        <a class="float-right" href="<?= BASEPAGES?>employee-forget-password.php">Forgot your password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="page" value="employee_sign_in">Sign In</button>
                </fieldset>

            </form>
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
<?php require_once(__DIR__ . "/../includes/page-level/auth/employee-signin.php") ?>


</body>

</html>
