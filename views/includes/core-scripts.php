<!-- Bootstrap core JavaScript-->
<script src="<?= BASEASSETS?>vendor/jquery/jquery.min.js"></script>
<script src="<?= BASEASSETS?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= BASEASSETS?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= BASEASSETS?>js/sb-admin-2.js"></script>

<!-- Toastr Javascript -->
<script src="<?=BASEASSETS;?>vendor/toastr/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    <?php
    if(Session::hasSession(ADD_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(ADD_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(ADD_SUCCESS);
    elseif(Session::hasSession(ADD_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(ADD_ERROR);?>", "Failure!");
    <?php
        Session::unsetSession(ADD_ERROR);
    elseif(Session::hasSession(EDIT_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(EDIT_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(EDIT_SUCCESS);
    elseif(Session::hasSession(EDIT_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(EDIT_ERROR);?>", "Failure!");
    <?php
        Session::unsetSession(EDIT_ERROR);
    elseif(Session::hasSession(VALIDATION_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(VALIDATION_ERROR);?>", "Failure!");
    <?php
        Session::unsetSession(VALIDATION_ERROR);
    elseif(Session::hasSession(DELETE_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(DELETE_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(DELETE_SUCCESS);
    elseif(Session::hasSession(DELETE_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(DELETE_ERROR);?>", "Failure!");
    <?php
        Session::unsetSession(DELETE_ERROR);
    elseif(Session::hasSession(LOGIN_REQUIRED)):
        ?>
            toastr.error("<?=Session::getSession(LOGIN_REQUIRED);?>", "Failure");
        <?php
            Session::unsetSession(LOGIN_REQUIRED);
    elseif(Session::hasSession(INVALID_CSRF)):
        ?>
            toastr.error("<?=Session::getSession(INVALID_CSRF);?>", "Failure");
        <?php
            Session::unsetSession(INVALID_CSRF);
    elseif(Session::hasSession(SIGNIN_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(SIGNIN_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(SIGNIN_SUCCESS);
    elseif(Session::hasSession(SIGNIN_ERROR)):
        ?>
            toastr.error("<?=Session::getSession(SIGNIN_ERROR);?>", "Failure");
        <?php
            Session::unsetSession(SIGNIN_ERROR);
    elseif(Session::hasSession(SIGNOUT_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(SIGNOUT_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(SIGNOUT_SUCCESS);
    elseif(Session::hasSession(SIGNOUT_ERROR)):
    ?>
          toastr.error("<?=Session::getSession(SIGNOUT_ERROR);?>", "Failure");
    <?php
        Session::unsetSession(SIGNOUT_ERROR);
    elseif(Session::hasSession(INCORRECT_PASSWORD_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(INCORRECT_PASSWORD_ERROR);?>", "Failure");
    <?php
        Session::unsetSession(INCORRECT_PASSWORD_ERROR);
    elseif(Session::hasSession(INCORRECT_USER_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(INCORRECT_USER_ERROR);?>", "Failure");
    <?php
        Session::unsetSession(INCORRECT_USER_ERROR);
    elseif(Session::hasSession(EMAIL_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(EMAIL_ERROR);?>", "Failure");
    <?php
        Session::unsetSession(EMAIL_ERROR);
    elseif(Session::hasSession(EMAIL_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(EMAIL_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(EMAIL_SUCCESS);
    elseif(Session::hasSession(PASSWORD_RESET_SUCCESS)):
    ?>
        toastr.success("<?=Session::getSession(PASSWORD_RESET_SUCCESS);?>", "Success");
    <?php
        Session::unsetSession(PASSWORD_RESET_SUCCESS);
    elseif(Session::hasSession(PASSWORD_RESET_ERROR)):
    ?>
        toastr.error("<?=Session::getSession(PASSWORD_RESET_ERROR);?>", "Failure");
    <?php
        Session::unsetSession(PASSWORD_RESET_ERROR);
    endif;
    ?>
</script>
