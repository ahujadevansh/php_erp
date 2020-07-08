<?php

class Customer {

    private $table = "customers";
    private $token_table = 'customer_tokens';
    public $who = 'CUS';
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
            'phone' => [
                'phone' => true,
            ],
        ]);
    }

    public function create($data) { //$data is mixed array
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $password = Util::randString();
                $data_to_be_inserted = [
                    'first_name' =>$data['first_name'],
                    'last_name' =>$data['last_name'],
                    'email' =>$data['email'],
                    'about' =>$data['about'],
                    'phone' =>$data['phone'],
                    'gender' =>$data['gender'],
                    'birthdate' =>$data['birthdate'],
                    'image' =>$data['image'],
                    'password'=> Hash::make($password),
                ];
                $customer_id = $this->database->insert($this->table, $data_to_be_inserted);
                $this->database->commit();
                $mail = $this->di->get('mail');
                $mail->addAddress($data['email']);
                $mail->Subject = "Thank You For Registring on {$this->di->get('config')->get('app_name')}";
                $mail->Body = <<<body
                    <b>Hello {$data['first_name']} {$data['last_name']},</b>
                    <h3>Thank you for registring on <a href="{$this->di->get('config')->get('base_url')}">{$this->di->get('config')->get('app_name')}</a></h3>
                    <p>
                        Here's Your Log in details are<br>
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

    public function delete($id) {
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table, "id={$id}");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollback();
            return DELETE_ERROR;
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

    public function getUserByEmail(string $email, $fields = []) {
        return $this->auth->getUserByEmail($this->table, $email, $fields);
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

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length) {
        $columns = ['sr_no', 'email', 'phone', 'gender'];
        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} Where deleted=0";
        $filteredRowCountQuery = "SELECT COUNT(id) as filtered_total_count FROM {$this->table} WHERE deleted=0";
        $query = "SELECT id, email, phone, gender FROM {$this->table} WHERE deleted=0";

        if($searchParameter != Null)
        {
            $query .= " AND (email LIKE '%{$searchParameter}%' OR phone LIKE '%{$searchParameter}%')";
            $filteredRowCountQuery .= " AND (email LIKE '%{$searchParameter}%' OR phone LIKE '%{$searchParameter}%')";
        }
        $orderByLength =  count($orderBy);

        if($orderBy != Null)
        {
            if($orderByLength==1)
            {
                $query .= " ORDER BY {$columns[$orderBy[0]['column']]} {$orderBy[0]['dir']}";
            }
            else
            {
                for ($i=0; $i<$orderByLength; $i++)
                {
                    if($i==0)
                    {
                        $query .= " ORDER BY {$columns[$orderBy[$i]['column']]} {$orderBy[$i]['dir']}";
                    }
                    else
                    {
                        $query .= ", {$columns[$orderBy[$i]['column']]} {$orderBy[$i]['dir']}";
                    }
                }
            }
        }
        else
        {
            //  if "order" is defined in java script this code is redundant
            $query .= " ORDER BY {$columns[0]} ASC";
        }

        if($length != -1)
        {
            $query .= " LIMIT {$start}, {$length};";
        }
        // die($query);
        $totalRowCountResult = $this->database->raw($totalRowCountQuery);
        $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

        $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);
        $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->filtered_total_count : 0;


        $filteredData = $this->database->raw($query);
        $numberOfRowsToDisplay = is_array($filteredData) ? count($filteredData) : 0;

        $data = array();
        for($i=0; $i<$numberOfRowsToDisplay; $i++)
        {
            $subarray = array();
            $subarray[] = $start+$i+1;
            $subarray[] = $filteredData[$i]->email;
            $subarray[] = $filteredData[$i]->phone;
            $subarray[] = $filteredData[$i]->gender;
            $subarray[] = <<<BUTTONS
                <a class='edit btn btn-outline-primary m-1' href="#" ><i class='fas fa-pencil-alt'></i>Edit</a>
                <button class='delete btn btn-outline-danger m-1' id='{$filteredData[$i]->id}' data-toggle="modal" data-target="#deleteModal"><i class='fas fa-trash'></i>Delete</button>
            BUTTONS;
            $data[] = $subarray;
        }

        $output = array(
            "draw"=>$draw,
            "recordsTotal"=>$numberOfTotalRows,
            "recordsFiltered"=>$numberOfFilteredRows,
            "data"=>$data,
        );

        echo json_encode($output);
    }
}



?>
