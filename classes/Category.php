<?php

require_once __DIR__."/../helper/requirements.php";

class Category{
    private $table = "category";
    private $database;
    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }

    private function validateData($data)
    {
        $validator = $this->di->get('validator');
        return $validator->check($data, [
            'name' => [
                'required' => true,
                'minlength' => 2,
                'maxlength' => 255,
                'unique' => $this->table
            ],
            'description' => [
                'required' => false,
            ]
        ]);
    }
    /**
     * This function is responsible to accept the data from the Routing and add it to the Database.
     */
    public function addCategory($data)
    {
        $validation = $this->validateData($data);
        if(!$validation->fails())
        {
            //Validation was successful
            try
            {
                //Begin Transaction
                $this->database->beginTransaction();
                $data_to_be_inserted = [
                    'name' => $data['name'],
                    'description' => $data['description']
                ];
                $category_id = $this->database->insert($this->table, $data_to_be_inserted);
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

    public function getJSONDataForDataTable($draw, $searchParameter, $orderBy, $start, $length)
    {
        $columns = ['sr_no', 'name', 'description'];
        $totalRowCountQuery = "SELECT COUNT(id) as total_count FROM {$this->table} Where deleted=0";
        $filteredRowCountQuery = "SELECT COUNT(id) as filtered_total_count FROM {$this->table} WHERE deleted=0";
        $query = "SELECT * FROM {$this->table} WHERE deleted=0";

        if($searchParameter != Null)
        {
            $query .= " AND name LIKE '%{$searchParameter}%'";
            $filteredRowCountQuery .= " AND name LIKE '%{$searchParameter}%'";
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
            $subarray[] = $i+1;
            $subarray[] = $filteredData[$i]->name;
            $description = $this->di->get('util')->truncateWords($filteredData[$i]->description, 25);
            if($description[1] == 1)
            {
                $description[0] .= <<<VIEWMORE
                <a class='edit m-1 text-primary' id='{$filteredData[$i]->id}' style="cursor: pointer;text-decoration: underline;" data-toggle="modal" data-target="#editModal">view more</a>
                VIEWMORE;
            }
            $subarray[] = $description[0];
            $subarray[] = <<<BUTTONS
                <button class='edit btn btn-outline-primary m-1' id='{$filteredData[$i]->id}' data-toggle="modal" data-target="#editModal"><i class='fas fa-pencil-alt'></i>Edit</button>
                <button class='delete btn btn-outline-danger m-1' id='{$filteredData[$i]->id}' data-toggle="modal" data-target="#deleteModal"><i class='fas fa-trash'></i>Delete</button>
            BUTTONS;
            $data[] = $subarray;
        }

        $output = array(
            "draw"=>$draw,
            "recordsTotal"=>$numberOfTotalRows,
            "recordsFiltered"=>$numberOfFilteredRows,
            "data"=>$data
        );

        echo json_encode($output);
    }


    public function getCategoryById($categoryId, $mode=PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->table} WHERE deleted = 0 AND id = {$categoryId}";
        $result = $this->database->raw($query, $mode);
        return $result;
    }

    public function update($data, $id)
    {
        $validationData['name'] = $data['category_name'];
        $validationData['description'] = $data['category_description'];
        $old = $this->getCategoryById($id);
        $editDescriptionOnly = False;
        if($old[0]->name == $validationData['name'])
        {
            $editDescriptionOnly = True;
        }
        $validation = $this->validateData($validationData);
        if(!$validation->fails() || $editDescriptionOnly)
        {
            try{
                $this->database->beginTransaction();
                $filteredData['name'] = $data['category_name'];
                $filteredData['description'] = $data['category_description'];
                $this->database->update($this->table, $filteredData, "id={$id}");
                $this->database->commit();
                return EDIT_SUCCESS;
            }catch(Exception $e){
                $this->database->rollback();
                return EDIT_ERROR;
            }
        }
        else
        {
            return VALIDATION_ERROR;
        }
    }

    public function delete($id)
    {
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

}
