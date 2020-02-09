<?php

class Util
{
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function redirect($filePath) {
        header('Location: ' . ($this->di->get('config')->get('base_url') . "views/pages/{$filePath}"));
    }

    public static function createCSRFToken() {
        Session::setSession('csrf_token', uniqid().rand());
        Session::setSession('token_expire', time()+3600);
    }

    public static function verifyCSRFToken($data) {
        return (isset($data['csrf_token']) && Session::getSession('csrf_token') != null && $data['csrf_token'] == Session::getSession('csrf_token') && Session::getSession('token_expire') > time());
    }

}


?>