<?php

class TokenHandler {

    private static $REMEMBER_EXPIRY_TIME = "30 minutes";
    private static $FORGET_PWD_EXPIRY_TIME = "15 minutes";

    private $database;
    private $di;

    public function __construct(DependancyInjector $di)
    {
        $this->di = $di;
        $this->database = $di->get('database');
        TokenHandler::$REMEMBER_EXPIRY_TIME = (int)$this->di->get('config')->get('REMEMBER_EXPIRY_TIME');
        TokenHandler::$FORGET_PWD_EXPIRY_TIME = (int)$this->di->get('config')->get('REMEMBER_EXPIRY_TIME');
    }

    public static function getCurrentTimeInMilliSec() {
        return round(microtime(true) * 1000);
    }

    public function getValidExixtingToken(string $token_table, int $user_id, int $isRemember) {
        $query = "SELECT * FROM {$token_table} WHERE USER_ID = {$user_id} and expires_at >= Now() and is_remember = {$isRemember}";
        $retVal = $this->database->raw($query, PDO::FETCH_ASSOC);
        return $retVal[0]['token'] ?? null;
    }

    public function createRememberMeToken(string $token_table, int $user_id) {
        return $this->createToken($token_table, $user_id, 1);
    }

    public function createForgetPasswordToken(string $token_table, int $user_id) {
        return $this->createToken($token_table, $user_id, 0);
    }

    private function createToken(string $token_table, int $user_id, int $isRemember) {
        $validToken = $this->getValidExixtingToken($token_table, $user_id, $isRemember);
        if($validToken) {
            return $validToken;
        }

        $current = time();
        $timeToBeAdded = $isRemember ? TokenHandler::$REMEMBER_EXPIRY_TIME : TokenHandler::$FORGET_PWD_EXPIRY_TIME;
        $data = [
            'user_id' => $user_id,
            'token' => Hash::generateRandomToken($user_id),
            'expires_at' => date("Y-m-d H:i:s", $current + $timeToBeAdded),
            'is_remember' => $isRemember
        ];
        $category_id = $this->database->insert($token_table, $data);
        return $data['token'];
    }

    public function isValid(string $token_table, string $token, int $isRemember) {

        return !empty($this->database->raw("SELECT * FROM {$token_table} WHERE token = '$token' and expires_at >= Now() and is_remember = $isRemember"));
    }

    public function getUserFromValidToken(string $token_table, string $token) {
        return $this->database->readData($token_table, [], "token = '{$token}'")[0];
    }

    public function deleteToken(string $token_table, string $token) {
        $sql = "DELETE FROM {$token_table} WHERE TOKEN = '{$token}'";
        return $this->database->query($sql);
    }

}


?>
