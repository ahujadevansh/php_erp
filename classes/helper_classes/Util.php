<?php

class Util
{
    private $di;
    private static $baseUrl;

    public function __construct($di)
    {
        $this->di = $di;
        self::$baseUrl = $this->di->get('config')->get('base_url');
    }

    public function redirect($filePath) {
        header('Location: ' . (self::$baseUrl . "views/pages/{$filePath}"));
    }

    public static function createCSRFToken() {
        Session::setSession('csrf_token', uniqid().rand());
        Session::setSession('token_expire', time()+3600);
    }

    public static function verifyCSRFToken($data) {
        return (isset($data['csrf_token']) && Session::getSession('csrf_token') != null && $data['csrf_token'] == Session::getSession('csrf_token') && Session::getSession('token_expire') > time());
    }

    public static function dd ($var= "") {
        die(var_dump($var));
    }

    public static function truncateWords($str, $count = 50, $apenDots=True)
    {
        $strArray = explode(" ",$str);
        $noOfWords = count($strArray);
        $strArray = array_slice($strArray, 0, $count);
        $more = 0;
        if($noOfWords > $count && $apenDots)
        {
            $strArray[] = "....";
            $more = 1;
        }
        return [implode(" ", $strArray), $more];
    }
}


?>
