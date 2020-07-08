<?php
require_once 'init.php';


if(isset($_POST['page']))
{
    if(isset($_POST['csrf_token'])) {

        if(Util::verifyCSRFToken($_POST)) {
            //USER HAS REQUESTED TO ADD A NEW CATEGORY
            if($_POST['page'] == 'add_category') {
                $result = $di->get('category')->addCategory($_POST);
                switch($result)
                {
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-category.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                        // Util::dd();
                        Util::redirect('manage-category.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-category.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'edit_category') {
                $result = $di->get('category')->update($_POST, $_POST['category_id']);
                switch($result)
                {
                    case EDIT_ERROR:
                        Session::setSession(EDIT_ERROR, 'There was problem while editing record, please try again later!');
                        Util::redirect('manage-category.php');
                        break;
                    case EDIT_SUCCESS:
                        Session::setSession(EDIT_SUCCESS, 'The record have been updated successfully!');
                        // Util::dd();
                        Util::redirect('manage-category.php');
                        break;
                    case VALIDATION_ERROR:
                        $errorHandler = $di->get('validator')->errors();
                        if ($errorHandler->has('name'))
                        {
                            Session::setSession(VALIDATION_ERROR, $errorHandler->first('name'));
                        }
                        Util::redirect('manage-category.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'delete_category') {
                $result = $di->get('category')->delete($_POST['record_id']);
                switch($result)
                {
                    case DELETE_ERROR:
                        Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                        Util::redirect('manage-category.php');
                        break;
                    case DELETE_SUCCESS:
                        Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                        // Util::dd();
                        Util::redirect('manage-category.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'add_product') {
                $result = $di->get('product')->addProduct($_POST);
                switch($result)
                {
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-product.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                        Util::redirect('manage-product.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-product.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'add_Product_store') {
                $result = $di->get('product')->addProductStore($_POST);
                // Util::dd($result);
                switch($result)
                {
                    case LOGIN_REQUIRED:
                        Session::setSession(LOGIN_REQUIRED, 'You Must signIn first');
                        Util::redirect('employee-signin.php');
                        break;
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-category.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                        // Util::dd();
                        Util::redirect('manage-product.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-product-store.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'add_supplier') {
                $result = $di->get('supplier')->create($_POST, $_FILES);
                switch($result)
                {
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-supplier.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The supplier have been registered successfully!');
                        // Util::dd();
                        Util::redirect('manage-supplier.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-supplier.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'add_sales') {
                $result = $di->get('transaction')->addSales($_POST);
                switch($result)
                {
                    case LOGIN_REQUIRED:
                        Session::setSession(LOGIN_REQUIRED, 'You Must signIn first');
                        Util::redirect('employee-signin.php');
                        break;
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('add-sales.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The record have been added successfully!');
                        // Util::dd();
                        Util::redirect('index.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-sales.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'add_employee') {
                $result = $di->get('employee')->create($_POST, $_FILES);
                switch($result)
                {
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-employee.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The employee have been registered successfully!');
                        // Util::dd();
                        Util::redirect('manage-employee.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-employee.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'employee_sign_in') {
                $result = $di->get('employee')->signIn($_POST);
                switch($result)
                {
                    case SIGNIN_ERROR:
                        Session::setSession(SIGNIN_ERROR, 'There was problem while signing in, please try again later!');
                        Util::redirect('employee-signin.php');
                        break;
                    case SIGNIN_SUCCESS:
                        Session::setSession(SIGNIN_SUCCESS, 'Sign In Successful');
                        Util::redirect('index.php');
                        break;
                    case INCORRECT_PASSWORD_ERROR:
                        Session::setSession(INCORRECT_PASSWORD_ERROR, 'Please Enter Correct Password');
                        Util::redirect('employee-signin.php');
                        break;
                    case INCORRECT_USER_ERROR:
                        Session::setSession(INCORRECT_USER_ERROR, 'Email not registered');
                        Util::redirect('employee-signin.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('employee-signin.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'employee_sign_out') {
                $result = $di->get('employee')->signOut();
                switch($result)
                {
                    case SIGNOUT_ERROR:
                        Session::setSession(SIGNOUT_ERROR, 'There was problem while signing out, please try again later!');
                        Util::redirect('index.php');
                        break;
                    case SIGNOUT_SUCCESS:
                        Session::setSession(SIGNOUT_SUCCESS, 'Sign Out Successful');
                        Util::redirect('employee-signin.php');
                        break;
                }
            }
            elseif ($_POST['page'] == 'employee_forget_password') {
                $result = $di->get('employee')->sendForgetPasswordMail($_POST);
                switch($result)
                {
                    case EMAIL_ERROR:
                        Session::setSession(EMAIL_ERROR, 'There was problem while sending email, please try again later!');
                        Util::redirect('index.php');
                        break;
                    case EMAIL_SUCCESS:
                        Session::setSession(EMAIL_SUCCESS, 'A mail with instrustions to reset password send to registered email address');
                        Util::redirect('index.php');
                        break;
                    case INCORRECT_USER_ERROR:
                        Session::setSession(INCORRECT_USER_ERROR, 'Email not registered');
                        Util::redirect('employee-forget-password.php');
                        break;
                    case VALIDATION_ERROR:
                    Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                    Session::setSession('errors', serialize($di->get('validator')->errors()));
                    Session::setSession('old', $_POST);
                    Util::redirect('employee-forget-password.php');
                    break;
                }
            }
            elseif ($_POST['page'] == 'employee_reset_password') {
                $result = $di->get('employee')->resetUserPassword($_POST);
                switch($result)
                {
                    case PASSWORD_RESET_ERROR:
                        Session::setSession(PASSWORD_RESET_ERROR, 'There was problem while resetting your password, please try again later!');
                        Util::redirect('employee-signin.php');
                        break;
                    case PASSWORD_RESET_SUCCESS:
                        Session::setSession(PASSWORD_RESET_SUCCESS, 'Your password is reseted. login to continue');
                        Util::redirect('employee-signin.php');
                        break;
                    case VALIDATION_ERROR:
                    Session::setSession(VALIDATION_ERROR, 'There was some problem in validating your data at server side!');
                    Session::setSession('errors', serialize($di->get('validator')->errors()));
                    Session::setSession('old', $_POST);
                    Util::redirect("employee-reset-password.php?token={$_POST['token']}&email={$_POST['email']}");
                    break;
                }
            }
            elseif($_POST['page'] == 'add_customer') {
                $result = $di->get('customer')->create($_POST);
                switch($result)
                {
                    case ADD_ERROR:
                        Session::setSession(ADD_ERROR, 'There was problem while inserting record, please try again later!');
                        Util::redirect('manage-customer.php');
                        break;
                    case ADD_SUCCESS:
                        Session::setSession(ADD_SUCCESS, 'The customer have been registered successfully!');
                        // Util::dd();
                        Util::redirect('manage-customer.php');
                        break;
                    case VALIDATION_ERROR:
                        Session::setSession('errors', serialize($di->get('validator')->errors()));
                        Session::setSession('old', $_POST);
                        Util::redirect('add-customer.php');
                        break;
                }
            }
            elseif($_POST['page'] == 'delete_customer') {
                $result = $di->get('customer')->delete($_POST['record_id']);
                switch($result)
                {
                    case DELETE_ERROR:
                        Session::setSession(DELETE_ERROR, 'There was problem while deleteing record, please try again later!');
                        Util::redirect('manage-customer.php');
                        break;
                    case DELETE_SUCCESS:
                        Session::setSession(DELETE_SUCCESS, 'The record have been deleted successfully!');
                        // Util::dd();
                        Util::redirect('manage-customer.php');
                        break;
                }
            }
        }
        else {
            Session::setSession(INVALID_CSRF, 'The request is time out. Please Try again!');
            Util::redirect('index.php');
        }
    }
    elseif($_POST['page'] == 'manage_category') {
        $search_parameter = $_POST['search']['value'] ?? null;
        $order_by = $_POST['order'] ?? null;
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        $di->get("category")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
    }
    elseif($_POST['page'] == 'manage_customer') {
        $search_parameter = $_POST['search']['value'] ?? null;
        $order_by = $_POST['order'] ?? null;
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        $di->get("customer")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
    }
    elseif($_POST['page'] == 'manage_product') {
        $search_parameter = $_POST['search']['value'] ?? null;
        $order_by = $_POST['order'] ?? null;
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        $di->get("product")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
    }
    else {
        Util::dd("page not found");
    }

}


if(isset($_POST['fetch'])) {

    if($_POST['fetch'] == 'category') {
        $category_id = $_POST['category_id'];
        $result = $di->get('category')->getCategoryById($category_id, PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
        if($_POST['fetch'] == 'getAllCategories') {
            echo json_encode($di->get('category')->all(['id', 'name']));
        }

        elseif($_POST['fetch'] == 'getAllBrands') {
            echo json_encode($di->get('brand')->all(['id', 'name']));
        }

        elseif($_POST['fetch'] == 'filterProductByCategory') {
            echo json_encode($di->get('product')->filterProductByBrandCategory($_POST['brand_id'], $_POST['category_id'], ['id', 'name']));
        }

        elseif($_POST['fetch'] == 'getSellingRateByProduct') {
            echo json_encode($di->get('product')->getSellingRateByProduct($_POST['product_id']));
        }

        elseif($_POST['fetch'] == 'getCustomerFromEmail') {
            echo json_encode($di->get('customer')->getUserByEmail($_POST['email'], ['id', 'email']));
        }

        elseif($_POST['fetch'] == 'getAllCountry') {
            echo json_encode($di->get('location')->getAllCountries());
        }
        elseif($_POST['fetch'] == 'getStates') {
            echo json_encode($di->get('location')->getStates($_POST['country_id']));
        }
        elseif($_POST['fetch'] == 'getCountryCodes') {
            echo json_encode($di->get('location')->getCountryCodes());
        }
    }
    else {
        echo "cross site";
    }
}




?>
