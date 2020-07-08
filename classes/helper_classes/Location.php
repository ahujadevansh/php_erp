<?php

class Location  {

    public static $data;
    private $database;
    private $di;
    public function __construct($di)
    {
        $this->di = $di;
        $this->database = $this->di->get('database');
    }

 // Fetch all countries list
    public function getAllCountries() {
        try {
            $result = $this->database->readData('countries', ['id', 'name']);
            if(!$result) {
                throw new exception("Country not found.");
            }
            $data = array(['status'=>1, 'result'=>$result]);
        }
        catch (Exception $e) {
            $data = array(['status'=>0, 'result'=>$e->getMessage()]);
        }
        finally {
            return $data;
        }
    }

    public function getCountryCodes() {
        try {
            $result = $this->database->readData('countries', ['phonecode', 'name']);
            if(!$result) {
                throw new exception("Country not found.");
            }
            $data = array(['status'=>1, 'result'=>$result]);
        }
        catch (Exception $e) {
            $data = array(['status'=>0, 'result'=>$e->getMessage()]);
        }
        finally {
            return $data;
        }
    }

  // Fetch all states list by country id
  public function getStates($countryId) {
     try {
       $result = $this->database->readData('states', ['id', 'name'], "country_id='{$countryId}'");
       if(!$result) {
         throw new exception("State not found.");
       }
       $data = array(['status'=>1, 'result'=>$result]);
     } catch (Exception $e) {
        $data = array(['status'=>0, 'result'=>$e->getMessage()]);
     } finally {
        return $data;
     }
   }

}
