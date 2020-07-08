<?php
require_once(__DIR__ . "/../../helper/init.php" );
$title = 'Easy ERP';
$sidebarSection = 'supplier';
$sidebarSubSection = 'add_supplier' ;
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
                        <h1 class="h3 mb-0 text-gray-800">Supplier</h1>
                        <a href="<?= BASEPAGES; ?>manage-supplier.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fa fa-list-ul fa-sm text-white-75"></i> Manage Supplier
                        </a>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Supplier</h6>
                                </div>
                                <form action="<?=BASEURL;?>helper/routing.php" method="POST" id="add-supplier" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token');?>">
                                            <div class="form-group">
                                                <label class="text-dark" for="email">Email<span class="required">*</span></label>
                                                <input  type="email" class="form-control" id="email" name="email"
                                                        value="<?=$old != '' && isset($old['email']) ?$old['email']: '';?>"
                                                        placeholder="Enter Email">
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
                                                    <input  type="text" class="form-control" id="first_name" name="first_name"
                                                            value="<?=$old != '' && isset($old['first_name']) ?$old['first_name']: '';?>"
                                                            placeholder="Enter Your First Name">
<?php
if($errors!="" && $errors->has('first_name'))
{
echo "<span class='error'>{$errors->first('first_name')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label class="text-dark" for="last_name">Last Name<span class="required">*</span></label>
                                                    <input  type="text" class="form-control" id="last_name" name="last_name"
                                                            value="<?=$old != '' && isset($old['last_name']) ?$old['last_name']: '';?>"
                                                            placeholder="Enter Your Last Name">

<?php
if($errors!="" && $errors->has('last_name'))
{
echo "<span class='error'>{$errors->first('last_name')}</span>";
}
?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="text-dark">Phone Number<span class="required">*</span></label>
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-2">
                                                        <select class="form-control" id="country_code" name="country_code" disabled>
                                                            <option value="" selected disabled>Select Country Code</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-10 col-sm-10">
                                                        <input  type="number" class="form-control" id="phone" name="phone"
                                                            value="<?=$old != '' && isset($old['phone']) ?$old['phone']: '';?>"
                                                            placeholder="Enter Your Phone Number">
                                                    </div>
                                                </div>

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
                                                        <option value="" selected disabled>Select Gender</option>
                                                        <option value="M" <?=($old != '' && isset($old['gender']) && $old['gender'] == 'M') ? 'selected' : '';?> >Male</option>
                                                        <option value="F" <?=($old != '' && isset($old['gender']) && $old['gender'] == 'F') ? 'selected' : '';?> >Female</option>
                                                        <option value="O" <?=($old != '' && isset($old['gender']) && $old['gender'] == 'O') ? 'selected' : '';?> >Other</option>
                                                    </select>
<?php
if($errors!="" && $errors->has('gender'))
{
echo "<span class='error'>{$errors->first('gender')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label for="gender" class="text-dark">Date of birth</label>
                                                    <input  type="date" class="form-control" id="birthdate" name="birthdate"
                                                            value="<?=$old != '' && isset($old['birthdate']) ?$old['birthdate']: '';?>" >

<?php
if($errors!="" && $errors->has('birthdate'))
{
echo "<span class='error'>{$errors->first('birthdate')}</span>";
}
?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label class="text-dark" for="building">Building<span class="required">*</span></label>
                                                    <input  type="text" class="form-control" id="building" name="building"
                                                            value="<?=$old != '' && isset($old['building']) ?$old['building']: '';?>"
                                                            placeholder="Flat/Building">
<?php
if($errors!="" && $errors->has('building'))
{
echo "<span class='error'>{$errors->first('building')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label class="text-dark" for="street">Street</label>
                                                    <input  type="text" class="form-control" id="street" name="street"
                                                            value="<?=$old != '' && isset($old['street']) ?$old['street']: '';?>"
                                                            placeholder="Street (Optional)">
<?php
if($errors!="" && $errors->has('street'))
{
echo "<span class='error'>{$errors->first('street')}</span>";
}
?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label class="text-dark" for="pincode">Pincode<span class="required">*</span></label>
                                                    <input  type="number" class="form-control" id="pincode" name="pincode"
                                                            value="<?=$old != '' && isset($old['pincode']) ?$old['pincode']: '';?>"
                                                            placeholder="Pincode">
<?php
if($errors!="" && $errors->has('pincode'))
{
echo "<span class='error'>{$errors->first('pincode')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6">
                                                    <label class="text-dark" for="landmark">Landmark</label>
                                                    <input  type="text" class="form-control" id="landmark" name="landmark"
                                                            value="<?=$old != '' && isset($old['landmark']) ?$old['landmark']: '';?>"
                                                            placeholder="Landmark (Optional)">
<?php
if($errors!="" && $errors->has('landmark'))
{
echo "<span class='error'>{$errors->first('landmark')}</span>";
}
?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-4">
                                                    <label class="text-dark" for="country_id">Country<span class="required">*</span></label>
                                                    <select class="form-control" id="country_id" name="country_id" disabled>
                                                        <option value="" selected disabled>Select Country</option>
                                                    </select>
<?php
if($errors!="" && $errors->has('country_id'))
{
echo "<span class='error'>{$errors->first('country_id')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-4">
                                                    <label class="text-dark" for="state_id">State<span class="required">*</span></label>
                                                    <select class="form-control" id="state_id" name="state_id" disabled>
                                                        <option value="" selected disabled>Select Country First</option>
                                                    </select>
<?php
if($errors!="" && $errors->has('state_id'))
{
echo "<span class='error'>{$errors->first('state_id')}</span>";
}
?>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-4">
                                                    <label class="text-dark" for="city">City<span class="required">*</span></label>
                                                    <input  type="text" class="form-control" id="city" name="city"
                                                            value="<?=$old != '' && isset($old['city']) ?$old['city']: '';?>"
                                                            placeholder="City">
<?php
if($errors!="" && $errors->has('city'))
{
echo "<span class='error'>{$errors->first('city')}</span>";
}
?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 col-sm-9">
                                                    <div class="form-group">
                                                        <label for="about" class="text-dark">About</label>
                                                        <textarea name="about" id="about" class="form-control"><?=$old != '' && isset($old['about']) ?$old['about']: '';?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image" class="text-dark">Profile Photo</label>
                                                        <input type="file" class="form-control-file border" id="image" name="image">
<?php
if($errors!="" && $errors->has('image'))
{
echo "<span class='error'>{$errors->first('image')}</span>";
}
?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-3">
                                                    <img class="rounded-circle" src="<?= BASEMEDIAURL?><?= NOIMAGE?>" alt="Image-Preview" id="preview-image" height="200" width="200">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mb-3" name="page" value="add_supplier">Add <i class="fa fa-user-plus px-1"></i></button>
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

    <!--PAGE LEVEL SCRIPTS-->
    <?php require_once(__DIR__ . "/../includes/page-level/supplier/add-supplier-scripts.php") ?>
</body>

</html>
