<?php

class Auth {


    private $database;
    protected $di;
    protected $authSession = 'user';
    protected $tokenHandler;

    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
        $this->tokenHandler = $this->di->get('tokenhandler');
    }

    private function validateSignInData($data)
    {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'email' => [
                'required' => true,
                'email' => true,
            ],
            'password' => [
                'required' => true,
                'minlength' => 8,
            ]
        ]);
    }

    public function setAuthSession($id) {
        $_SESSION[$this->authSession] = $id;
    }

    public function unsetAuthSession() {
        unset($_SESSION[$this->authSession]);
    }

    public function signIn(string $table, string $token_table,string $who, $data) //$data is mixed array
    {
        $validation = $this->validateSignInData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $email = $data['email'];
                $password = $data['password'];
                $rememberMe = $data['remember_me'] ?? null; // php 7 operator if set return data else null
                $user = $this->database->readData($table, ['id', 'password'], "email = '{$email}'");
                if(count($user) == 1) {
                    $user = $user[0];
                    if(Hash::verify($password, $user->password)) {
                        $this->setAuthSession($user->id);
                        if($rememberMe) {
                            $token = $this->tokenHandler->createRememberMeToken($token_table, $user->id);
                            $cookie_time = (int)$this->di->get('config')->get('REMEMBER_EXPIRY_TIME');
                            setcookie('token', $token, time()+ $cookie_time, '/');
                            setcookie('who', $who, time()+ $cookie_time, '/');
                        }
                        else {
                            setcookie('who', $who, 0, '/');
                        }
                        $this->database->commit();
                        return SIGNIN_SUCCESS;
                    }
                    else{
                      return INCORRECT_PASSWORD_ERROR;
                    }
                }
                return INCORRECT_USER_ERROR;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return SIGNIN_ERROR;
            }
        }
        else
        {
            //Validation Failed!
            return VALIDATION_ERROR;
        }
    }

    public function signout(string $token_table) {

        $user_id = $_SESSION[$this->authSession];
        try
        {
            //Begin Transaction
            $this->database->beginTransaction();
            // $sql = "DELETE FROM {$token_table} WHERE user_id = {$user_id} and is_remember=1";
            $sql = "DELETE FROM {$token_table} WHERE user_id = {$user_id}";
            $this->database->query($sql);
            setcookie('token', '', time()-5000);
            $this->unsetAuthSession();
            $this->database->commit();
            return SIGNOUT_SUCCESS;
        }
        catch(Exception $e)
        {
            $this->database->rollback();
            return SIGNOUT_ERROR;
        }
    }


    public function check() {
        return isset($_SESSION[$this->authSession]);
    }

    public function loginRequired() {
        if(!$this->check()) {
            Session::setSession(LOGIN_REQUIRED, 'You Must signIn first');
            Util::redirect('employee-signin.php');
        }
    }

    public function user(string $table) {
        if(!$this->check()) {
            return false;
        }
        $user = $this->database->readData($table, [], "id = {$_SESSION[$this->authSession]}");
        return $user[0];
    }

    public function getUserByEmail(string $table, string $email, $fields = []) {
        $user = $this->database->readData($table, $fields, "email='{$email}'");
        if ($user){
            $user = $user[0];
        }
        else {
            $user = null;
        }
        return $user;
    }

    public function sendForgetPasswordMail(string $table, string $token_table, $data) {

      $email = $data['email'];
      $validation = $this->di->get('validator')->check($data, [
            'email' => [
                'required' => true,
                'email' => true,
            ],
        ]);
      if(!$validation->fails())
      {
        $user = $this->getUserByEmail($table, $email);
        if($user) {
          // Util::dd($user->id);
            $token = $this->di->get('tokenhandler')->createForgetPasswordToken($token_table, (int)$user->id);
            if($token) {
                $BASEPAGES = BASEPAGES;
                $mail = $this->di->get('mail');
                $mail->addAddress($user->email);
                $mail->Subject = "Reset Password!";
                $mail->Body = "USE the below link within 15 minutes to reset your password.<br> <a href='{$BASEPAGES}employee-reset-password.php?token={$token}&email={$email}'>RESET PASSWORD</a>";
                if($mail->send()) {
                  return EMAIL_SUCCESS;
                }
                else {
                    // Util::dd($mail->ErrorInfo);
                    return EMAIL_ERROR;
                }
            }
        }
        return INCORRECT_USER_ERROR;
      }
      else {
        return VALIDATION_ERROR;
      }
    }

    public function resetUserPassword(string $table, string $token_table, $data) {

        $token = $data['token'];
        $password = $data['password'];
        $validation = $this->di->get('validator')->check($data, [
            'password' => [
                'required' => true,
                'minlength' => 8,
            ],
        ]);
        if(!$validation->fails()) {

          if($this->tokenHandler->isValid($token_table, $token, 0)) {
            $password = Hash::make($password);
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $password_update_flag = $this->database->query("UPDATE {$table}, {$token_table} SET {$table}.password = '{$password}', {$token_table}.expires_at = Now() WHERE {$table}.id = {$token_table}.user_id and {$token_table}.token='{$token}'");
                $token_delete_flag = $this->tokenHandler->deleteToken($token_table, $token);
                $this->database->commit();
                if( $password_update_flag && $token_delete_flag){
                  return PASSWORD_RESET_SUCCESS;
                }
                else{
                  return PASSWORD_RESET_ERROR;
                }
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return PASSWORD_RESET_ERROR;
            }
          }
          return PASSWORD_RESET_ERROR;
        }
        else{
          return VALIDATION_ERROR;
        }
    }

}

?>
