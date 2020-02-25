<script src="<?=BASEASSETS;?>vendor/toastr/toastr.min.js"></script>
<script src="<?=BASEASSETS;?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASEASSETS;?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
        toastr.error("<?=Session::getSession(ADD_ERROR);?>", "Success");
    <?php
        Session::unsetSession(ADD_ERROR);
    endif;
    ?>
</script>

<script src="<?=BASEASSETS;?>js/pages/category/manage-category.js" ></script>

