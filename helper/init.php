<?php
ini_set('session.cookie_lifetime',  0);
session_start();
require_once(__DIR__ . "/requirements.php");

$di = new DependancyInjector();
$di->set("config", new Config());
$di->set("database", new Database($di));
$di->set('hash', new Hash());
$di->set("errorhandler", new ErrorHandler());
$di->set("validator", new Validator($di));
$di->set("util", new Util());
$di->set("tokenhandler", new TokenHandler($di));
$di->set("auth", new Auth($di));
$di->set("location", new Location($di));
$di->set('mail', MailConfigHelper::getMailer());
$di->set("employee", new Employee($di));
$di->set("customer", new Customer($di));

$di->set("brand", new Brand($di));
$di->set("category", new Category($di));
$di->set("product", new Product($di));
$di->set("supplier", new Supplier($di));
$di->set("transaction", new Transaction($di));

require_once "constants.php";

$_USER = null;
if(isset($_COOKIE['token'])) {
    if($di->get('employee')->isValid($_COOKIE['token'], 1)){

        // i want the user or user id
        $token = $di->get('employee')->getUserFromValidToken($_COOKIE['token']);
        $di->get('auth')->setAuthSession($token->user_id);
    }
}

if(isset($_COOKIE['who']) && $di->get('auth')->check()) {
    if($di->get('employee')->who == $_COOKIE['who']) {
        $_USER = $di->get('employee')->user();
    }
}
else{
    $di->get('auth')->unsetAuthSession();
}

?>
