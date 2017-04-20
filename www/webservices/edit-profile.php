<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class EditProfile {
    
    public function __construct() {
    } 

    // Login Method
    public function editProfile($connection, $userid) {
        
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * FROM `user_details` WHERE `User_Id` = '".$userid."'");
        $results = new stdClass();
    //file_put_contents(dirname(__FILE__)."/res.log",print_r($results , true));
        
        //fetching records from database sent it to view.
        if ($statement->num_rows > 0) {
            foreach( $statement->fetch_assoc() as $key => $user ){
                $results->$key = $user;
                
            }
        } else {
            //error occur when someone entered incorrect details.
            $results->error = "OOPS! You Entered Incorrect Details!";
        }
            
           //file_put_contents(dirname(__FILE__)."/re123.log",print_r($ac , true));
           //file_put_contents(dirname(__FILE__)."/re1.log",print_r($results , true));
            return $results;
       
    }

    
}

$webservices = new EditProfile();

if(!empty($_REQUEST) && (($_REQUEST['userid'] != ""))){
        // Calling the register method and store the output in result variable
            //echo "register";
            $result = $webservices->editProfile($mysqli, $_REQUEST['userid']);
        }



// Converted it into JSON encode and display it 
 echo json_encode(array('results'=>$result));
?>