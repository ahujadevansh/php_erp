<?php

class Supplier {

    private $table = "suppliers";
    private $supplier_address_table = "supplier_address";
    private $database;
    private $di;
    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
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
            'phone' => [
                'required' => true,
                'phone' => true,
            ],
            'gender' => [
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
        ]);
    }

    public function create($data, $files) { //$data is mixed array

        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $birthdate = $data['birthdate'];
                $birthdate = date('Y-m-d', strtotime($birthdate));
                $data['birthdate'] = $birthdate;
                $data_to_be_inserted = [
                    'first_name' =>$data['first_name'],
                    'last_name' =>$data['last_name'],
                    'email' =>$data['email'],
                    'about' =>$data['about'],
                    'phone' =>$data['country_code']+$data['phone'],
                    'gender' =>$data['gender'],
                    'birthdate' =>$birthdate,
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
                    $image_name = "suppliers/profile_image/{$file_name}_{$time}.{$ext}";
                    $hasImage = true;
                }
                else
                {
                    $image_name = NOIMAGE;
                }
                $data_to_be_inserted['image'] = $image_name;
                $supplier_id = $this->database->insert($this->table, $data_to_be_inserted);
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
                $supplier_address_id = $this->database->insert($this->supplier_address_table, ['supplier_id'=>$supplier_id, 'address_id'=>$address_id]);
                $this->database->commit();
                if($hasImage)
                {
                    $temp_file_path  = $files['image']['tmp_name'];
                    move_uploaded_file($temp_file_path, BASEMEDIA . $image_name);
                }
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
}



?>
