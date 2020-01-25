<?php
require_once("helper\init.php");

$db = new Database($di);

$data = ['token'=>'ndsjncj'];

var_dump($db->readData('users'));

?>