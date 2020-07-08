<?php

class Util
{
    private static $baseUrl;

    public function __construct() {
        self::$baseUrl = parse_ini_file(__DIR__."/../../config.ini")['base_url'];
    }

    public static function redirect($filePath) {
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

    public static function truncateWords($str, $count = 50, $apenDots=True) {
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

    public static function createAssocArray($arrayOfKeys, $data){
        $assoc_array = array();
        foreach($arrayOfKeys as $key){
            $assoc_array[$key] = $data[$key];
        }
        return $assoc_array;
    }

    public static function randString($length = 8){
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$';
        $str = '';
        $max = strlen($chars) - 1;

        for ($i=0; $i < $length; $i++)
          $str .= $chars[random_int(0, $max)];

        return $str;
    }
}


?>
