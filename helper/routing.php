<?php
require_once 'init.php';


if(isset($_POST['page']))
{
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
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

        if($_POST['page'] == 'edit_category') {
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

        if($_POST['page'] == 'delete_category') {
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

        if($_POST['page'] == 'add_product') {
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

    }

    if($_POST['page'] == 'manage_category')
    {
        $search_parameter = $_POST['search']['value'] ?? null;
        $order_by = $_POST['order'] ?? null;
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        $di->get("category")->getJSONDataForDataTable($draw, $search_parameter, $order_by, $start, $length);
    }

}


if(isset($_POST['fetch']) && $_POST['fetch'] == 'category')
{
    $category_id = $_POST['category_id'];
    $result = $di->get('category')->getCategoryById($category_id, PDO::FETCH_ASSOC);
    echo json_encode($result);
}



?>
