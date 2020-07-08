<?php

require_once __DIR__."/../helper/requirements.php";

class Transaction{
    private $sales_table = "sales";
    private $invoice_table = "invoice";
    private $database;
    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }

    private function validateSalesData($data)
    {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
                'customer_id' => [
                    "required" => true,
                ],
                'product_id' => [
                    'required'=> true,
                ],
                'quantity' => [
                    'required'=> true,
                    'min'=> 1,
                ],
                'discount' => [
                    'required'=> true,
                    'min'=> 0,
                    'max'=> 100,
                ],
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addSales($data) {
        if($this->di->get('auth')->check() && $this->di->get('employee')->who == $_COOKIE['who']) {
            $user = $this->di->get('employee')->user();
            $validation = $this->validateSalesData($data);
            if(!$validation->fails()) {
                //Validation was successful
                try
                {
                    //Begin Transaction
                    $this->database->beginTransaction();
                    $data_to_be_inserted = ['store_id'=>$user->store_id, 'customer_id' => $data['customer_id']];
                    $invoice_id = $this->database->insert($this->invoice_table, $data_to_be_inserted);
                    $no_of_products = count($_POST['product_id']);
                    for($i=0; $i<$no_of_products; $i++) {
                        $data_to_be_inserted = [
                            'quantity'=> $data['quantity'][$i],
                            'discount'=> $data['discount'][$i],
                            'invoice_id'=> $invoice_id,
                            'product_id'=> $data['product_id'][$i],
                        ];
                        $sales_id = $this->database->insert($this->sales_table, $data_to_be_inserted);
                    }
                    $this->database->commit();
                    return ADD_SUCCESS;
                }
                catch(Exception $e)
                {
                    $this->database->rollback();
                    return ADD_ERROR;
                }
            }
            else {
                //Validation Failed!
                return VALIDATION_ERROR;
            }
        }
        else {
            return LOGIN_REQUIRED;
        }
    }


}
