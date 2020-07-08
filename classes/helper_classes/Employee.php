<?php

class Employee {

    private $table = "employees";
    private $token_table = 'employee_tokens';
    private $employee_address_table = "employee_address";
    private $employee_salary_table = 'employee_salary';
    public $who = 'EMP';
    private $database;
    private $di;
    private $auth;
    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
        $this->auth = $this->di->get('auth');
    }
    // public function build() {
    //     // echo "From Build";
    //     return $this->database->query(
    //     "CREATE TABLE IF NOT EXISTS {$this->table}(id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, email VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL)"
    //     );
    // }

    private function validateData($data) {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'email' => [
                'required' => true,
                'email' => true,
                'minlength' => 2,
                'maxlength' => 255,
                'unique' => $this->table
            ],
            'first_name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'last_name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'store_id' => [
                'required' => true,
            ],
            'type_id' => [
                'required' => true,
            ],
            'phone' => [
                'required' => true,
                'phone' => true,
            ],
            'gender' => [
                'required' => true,
            ],
            'birthdate' => [
                'required' => true,
            ],
            'building' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'street' => [
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'pincode' => [
                'required' => true,
                'minlength' => 7,
                'maxlength' => 7,
            ],
            'landmark' => [
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'city' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
            ],
            'state_id' => [
                'required' => true,
            ],
            'country_id' => [
                'required' => true,
            ],
            'salary' => [
                'required' => true,
                'min' => 0
            ],
            'date_of_joining' => [
                'required' => true,
            ],
        ]);
    }

    public function create($data, $files) { //$data is mixed array

        $data['image'] = $files['image']['name'];
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $password = Util::randString();
                $birthdate = $data['birthdate'];
                $birthdate = date('Y-m-d', strtotime($birthdate));
                $data['birthdate'] = $birthdate;
                $date_of_joining = $data['date_of_joining'];
                $birthdate = date('Y-m-d', strtotime($date_of_joining));
                $data['date_of_joining'] = $date_of_joining;
                $data_to_be_inserted = [
                    'first_name' =>$data['first_name'],
                    'last_name' =>$data['last_name'],
                    'email' =>$data['email'],
                    'about' =>$data['about'],
                    'phone' =>$data['country_code']+$data['phone'],
                    'gender' =>$data['gender'],
                    'birthdate' =>$birthdate,
                    'password'=> Hash::make($password),
                    'store_id'=>$data['store_id'],
                    'type_id'=>$data['type_id'],
                    'date_of_joining'=>$data['date_of_joining'],
                ];
                $hasImage = false;
                if($files['cover_image']['size'] == 0 && $files['cover_image']['error'] == 0)
                {
                    $file_name = $files['image']['name'];
                    if(strlen($file_name) > 250):
                        $file_name = substr($file_name,0,250);
                    endif;
                    $temp = explode('.', $file_name);
                    $ext = end($temp);
                    $file_name = $temp[0];
                    $time = time();
                    $image_name = "employees/profile_image/{$file_name}_{$time}.{$ext}";
                    $hasImage = true;
                }
                else
                {
                    $image_name = NOIMAGE;
                }
                $data_to_be_inserted['image'] = $image_name;
                $employee_id = $this->database->insert($this->table, $data_to_be_inserted);
                $address_data = [
                    'building' => $data['building'],
                    'street' => $data['street'],
                    'landmark' => $data['landmark'],
                    'pincode' => $data['pincode'],
                    'city' => $data['city'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id'],
                ];
                $address_id = $this->database->insert("addresses", $address_data);
                $employee_address_id = $this->database->insert($this->employee_address_table, ['employee_id'=>$employee_id, 'address_id'=>$address_id]);
                $salary_data = [
                    'salary'=> $data['salary'],
                    'wef'=> $data['date_of_joining'],
                    'employee_id'=> $employee_id,
                ];
                $salary_id = $this->database->insert($this->employee_salary_table, $salary_data);
                $this->database->commit();
                if($hasImage)
                {
                    $temp_file_path  = $files['image']['tmp_name'];
                    move_uploaded_file($temp_file_path, BASEMEDIA . $image_name);
                }
                $mail = $this->di->get('mail');
                $mail->addAddress($data['email']);
                $mail->Subject = "Thank You For Registring on {$this->di->get('config')->get('app_name')}";
                $mail->Body = <<<body
                    <b>Hello {$data['first_name']} {$data['last_name']},</b>
                    <h3>Thank you for registring on <a href="{$this->di->get('config')->get('base_url')}">{$this->di->get('config')->get('app_name')}</a></h3>
                    <p>
                        Here's Your employee Log in details are<br>
                        email: "{$data['email']}"<br>
                        password: "{$password}"
                    </p>
                body;
                $mail->send();
                return ADD_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollback();
                return ADD_ERROR;
            }
        }
        else
        {
            //Validation Failed!
            return VALIDATION_ERROR;
        }
    }

    public function signIn($data) { //$data is mixed array
        return $this->auth->signIn($this->table, $this->token_table, $this->who, $data);
    }

    public function signout() {
        return $this->auth->signout($this->token_table);
    }

    // returns false if user not loggedin else user object
    public function user() {
        return $this->auth->user($this->table);
    }

    public function getUserByEmail(string $email) {
        return $this->auth->getUserByEmail($this->table, $email);
    }

    public function sendForgetPasswordMail($data)
    {
      return $this->auth->sendForgetPasswordMail($this->table, $this->token_table, $data);
    }

    public function resetUserPassword($data) {

        return $this->auth->resetUserPassword($this->table, $this->token_table, $data);
    }

    public function isValid(string $token, int $isRemember) {

      return $this->di->get('tokenhandler')->isValid($this->token_table, $token, $isRemember);
    }

    public function getUserFromValidToken(string $token) {
        return $this->di->get('tokenhandler')->getUserFromValidToken($this->token_table, $token);
    }
}



?>
