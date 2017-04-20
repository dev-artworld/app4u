<?php
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class PasswordExist {
    
    public function __construct() {
    } 

    // Login Method
    public function passwordeXist($connection, $password) {
        
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * FROM `user_details` WHERE `Password` = '".$password."'");
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

$webservices = new PasswordExist();

if(!empty($_REQUEST) && (($_REQUEST['password'] != ""))){
        // Calling the register method and store the output in result variable
            //echo "register";
            $result = $webservices->passwordeXist($mysqli, $_REQUEST['password']);
        }



// Converted it into JSON encode and display it 
 echo json_encode(array('results'=>$result));
?>