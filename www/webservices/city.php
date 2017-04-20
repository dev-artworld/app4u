<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class City {
    
    public function __construct() {
    } 
   

    // Login Method
    public function city($connection, $state) {
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * from cities where state_code='$state'");
      //  $results = new stdClass();
        //fetching records from database sent it to view.





        if ($statement->num_rows > 0) {
           $arr = array();

            while( $row = $statement->fetch_assoc() ){

                $results = new stdClass();

                foreach ($row as $key => $value) {
                                    # code...
                    $results->$key = $value;

                }                

                $arr[] = $results; 
            }
        } else {
            //error occur when someone entered incorrect details.
            $results->error = "OOPS! You Entered Incorrect Details!";
        }
        //file_put_contents(dirname(__FILE__)."/re1.log",print_r($results , true));
        return $arr;
       
    }

    
}

$webservices = new City();

if(!empty($_REQUEST) && (($_REQUEST['state'] != ""))){
        // Calling the register method and store the output in result variable
            
            $result = $webservices->city($mysqli, $_REQUEST['state']);
        }



// Converted it into JSON encode and display it 
echo json_encode(array('results'=>$result));
?>