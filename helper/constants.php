<?php

define('BASEURL', $di->get('config')->get('base_url'));
define('BASEASSETS', BASEURL . "assets/");
define('VENDOR', BASEURL . "vendor/");
define('BASEPAGES', BASEURL . "views/pages/");
define('BASEMEDIAURL', BASEURL . "media/");
define('BASEMEDIA', __DIR__ . "/../media/");
define('NOIMAGE', "noimage.jpg");

define('ADD_ERROR', "add_error");
define('ADD_SUCCESS', "add_success");
define('VALIDATION_ERROR', "validation_error");

define("EDIT_ERROR", "edit_error");
define("EDIT_SUCCESS", "edit_success");

define("DELETE_ERROR", "delete_error");
define("DELETE_SUCCESS", "delete_success");

define('SIGNIN_ERROR', "sign_in_error");
define('SIGNIN_SUCCESS', "sign_in_success");

define('SIGNOUT_ERROR', "sign_out_error");
define('SIGNOUT_SUCCESS', "sign_out_success");

define('EMAIL_SUCCESS', "email_success");
define('EMAIL_ERROR', "email_error");

define('LOGIN_REQUIRED', 'login_required');
define('INCORRECT_USER_ERROR', 'incorrect_user');
define('PASSWORD_RESET_SUCCESS', "password_reset_success");
define('PASSWORD_RESET_ERROR', "password_reset_error");
define('INCORRECT_PASSWORD_ERROR', 'incorrect_password');

define('INVALID_CSRF', 'invalid_csrf');

?>
