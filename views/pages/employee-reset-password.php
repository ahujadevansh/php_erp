<?php
    require_once(__DIR__ . "/../../helper/init.php" );
    $title = "Easy ERP | Employee Reset Password";
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
<?php

if(isset($_GET['token']) && isset($_GET['email'])):

    $token = $_GET['token'];
    $email = $_GET['email'];

    if($di->get('employee')->isValid($token, 0)):
?>
                <!-- Outer Row -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                        </div>
                                        <form class="user" action="<?=BASEURL?>/helper/routing.php" method="POST">
                                            <input type="hidden" name="csrf_token", value="<?=Session::getSession('csrf_token');?>">
                                            <input type="hidden" name="token" value="<?= $token; ?>">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" id="email" value="<?=$email?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Enter New Password...">
                                            <div class="password_error"> </div>
<?php
if($errors!="" && $errors->has('password'))
{
    echo "<span class='error'>{$errors->first('password')}</span>";
}
?>
                                        </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block" name="page" value="employee_reset_password">
                                                Reset Password
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
<?php
    else:
        echo"<p>something Fishy!! I'll report to the admin</p>";
    endif;
else:
    echo"<p>How did you reach here??</p>";
endif;
?>
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
<?php require_once(__DIR__ . "/../includes/page-level/auth/employee-reset-password-scripts.php") ?>


</body>

</html>
