<?php
require_once(__DIR__ . "/../../helper/init.php" );
$title = "Easy ERP | Employee Forget Password";
$sidebarSection = '';
$sidebarSubSection = '' ;
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
            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                            <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                                        </div>
                                        <form class="user" action="<?=BASEURL?>helper/routing.php" method="POST">
                                            <input type="hidden" name="csrf_token", value="<?=Session::getSession('csrf_token');?>">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" name="email" id="email" value="<?=$old != '' && isset($old['email']) ?$old['email']: '';?>"aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                                <div class="email_error"> </div>
<?php
  if($errors!="" && $errors->has('email'))
  {
    echo "<span class='error'>{$errors->first('email')}</span>";
  }
?>                                          </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block" name="page" value="employee_forget_password">
                                                Forget Password
                                            </button>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="register.html">Create an Account!</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="<?=BASEPAGES?>employee-signin.php">Already have an account? SignIn!</a>
                                        </div>
                                    </div>
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
<?php require_once(__DIR__ . "/../includes/page-level/auth/employee-forget-password-scripts.php") ?>


</body>

</html>
