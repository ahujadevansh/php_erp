<?php

require_once __DIR__."/../helper/requirements.php";

class Product{
    private $table = "products";
    private $product_store_table = "product_store";
    private $product_selling_rate = "product_selling_rate";
    private $database;
    protected $di;

    public function __construct($di) {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }

    private function validateData($data) {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
                'name' => [
                    'required'=> true,
                    'minlength'=> 2,
                    'maxlength'=> 255,
                    'unique'=> $this->table
                ],
                'specification' => [
                    'required'=> false
                ],
                'hsn_code' => [
                    'required'=> true,
                    'minlength'=> 5,
                    'maxlength'=>128
                ],
                'brand_id' => [
                    'required'=> true,
                ],
                'category_id' => [
                    'required'=> true,
                ],
                'supplier_id' => [
                    'required' => true,
                ],
                'selling_rate' => [
                    'required'=> true,
                ],
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addProduct($data) {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $columnsOfProductTable = ["name", "specification", "hsn_code","brand_id", "category_id"];
                $data_to_be_inserted = Util::createAssocArray($columnsOfProductTable, $data);
                $product_id = $this->database->insert($this->table, $data_to_be_inserted);
                $data_to_be_inserted = [];
                $data_to_be_inserted['product_id'] = $product_id;
                foreach($data['supplier_id'] as $supplier_id){
                    $data_to_be_inserted['supplier_id'] = $supplier_id;
                    $this->database->insert('product_supplier', $data_to_be_inserted);
                }
                $data_to_be_inserted = [];
                $data_to_be_inserted['product_id'] = $product_id;
                $data_to_be_inserted['selling_rate'] = $data['selling_rate'];
                $data_to_be_inserted['wef'] = date("Y-m-d H:i:s", time());
                $this->database->insert($this->product_selling_rate, $data_to_be_inserted);
                $this->database->commit();
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

    public function addProductStore($data) {
        if($this->di->get('auth')->check() && $this->di->get('employee')->who == $_COOKIE['who']) {
            $user = $this->di->get('employee')->user();
            $validation = $this->validateData($data);
            if(!$validation->fails()) {
                //Validation was successful
                try
                {
                    //Begin Transaction
                    $this->database->beginTransaction();
                    $columnsOfProductTable = ["product_id", "quantity", "eoq_level","danger_level"];
                    $data_to_be_inserted = Util::createAssocArray($columnsOfProductTable, $data);
                    $data_to_be_inserted['store_id'] = $user->store_id;
                    $product_store_id = $this->database->insert($this->product_store_table, $data_to_be_inserted);
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

    public function filterProductByCategory(int $categoryId, $fields = []) {

        return $this->database->readData($this->table, $fields, "category_id = {$categoryId} AND deleted = 0", PDO::FETCH_ASSOC);
    }

    public function filterProductByBrand(int $brandId, $fields = []) {

        return $this->database->readData($this->table, $fields, "brand_id = {$brandId} AND deleted = 0", PDO::FETCH_ASSOC);
    }

    public function filterProductByBrandCategory($brandId, $categoryId, $fields = []) {

        if($brandId && $categoryId):
            return $this->database->readData($this->table, $fields, "brand_id = {$brandId} AND category_id = {$categoryId} AND deleted = 0", PDO::FETCH_ASSOC);
        elseif($brandId):
            return $this->filterProductByBrand($brandId, $fields);
        else:
            return $this->filterProductByCategory($categoryId, $fields);
        endif;

    }

    public function getSellingRateByProduct(int $product_id) {
        $query = "select p1.product_id, p1.selling_rate, p1.wef from product_selling_rate p1 INNER JOIN (SELECT product_id, MAX(wef) AS wef FROM product_selling_rate where wef <= CURRENT_TIMESTAMP GROUP by product_id HAVING product_id={$product_id}) p2 on p2.wef=p1.wef AND p1.product_id = p2.product_id;";

        return $this->database->raw($query, PDO::FETCH_ASSOC);
    }
}
