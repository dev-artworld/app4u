<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class ServiceData {
    
    public function __construct() {
    } 
   

    // Login Method
    public function serviceData($connection, $date) {
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT us.Status,us.StartDate, s.Service_Name, ud.First_Name,ud.Surname,ud.User_Id FROM user_service as us INNER JOIN provider_service as ps ON us.PROVIDER_sERVICE_iD = ps.Provider_Service_Id INNER JOIN user_details as ud ON ud.User_Id = us.User_ID INNER JOIN services AS s ON s.Service_Id = ps.Service_ID WHERE us.StartDate = '$date'");
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

$webservices = new ServiceData();

if(!empty($_REQUEST) && (($_REQUEST['date'] != ""))){
        // Calling the register method and store the output in result variable
            
            $result = $webservices->serviceData($mysqli, $_REQUEST['date']);
        }



// Converted it into JSON encode and display it 
echo json_encode(array('results'=>$result));
?>