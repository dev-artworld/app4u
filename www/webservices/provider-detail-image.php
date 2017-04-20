<?php
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class ProviderDetailImage {
    
    public function __construct() {
    } 
   

    // Login Method
    public function providerDetailimage($connection, $provideid) {
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT Image_Link from provider_service_gallery
 where Provider_Service_ID = '$provideid'");
        
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


        //file_put_contents(dirname(__FILE__)."/array.log",print_r($arr , true));

        //file_put_contents(dirname(__FILE__)."/re22.log",print_r($arr , true));
        return $arr;
       
    }

    
}

$webservices = new ProviderDetailImage();

if(!empty($_REQUEST) && ($_REQUEST['provideid'] != "")){
        // Calling the register method and store the output in result variable
            
            $result = $webservices->providerDetailimage($mysqli,$_REQUEST['provideid']);
        }



// Converted it into JSON encode and display it 
echo json_encode(array('results'=>$result));
?>