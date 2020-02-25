<?php
require_once 'init.php';

if(isset($_POST['add_category']))
{
    //USER HAS REQUESTED TO ADD A NEW CATEGORY
    if(isset($_POST['csrf_token']) && Util::verifyCSRFToken($_POST))
    {
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
}

if(isset($_POST['page']))
{
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
?>
