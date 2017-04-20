<?php
session_start();

$mysqli = new mysqli('localhost','cyberxau_demo','deep&*^art','cyberxau_app4u');

class ForgetPass {
    
    public function __construct() {
    } 

    // Login Method
    public function forgetPass($connection, $email) {
        
        $statement = $connection->query("SELECT * FROM `users` WHERE `email` = '".$email."'");
        $results = new stdClass();
  
        //fetching records from database sent it to view.
        if ($statement->num_rows > 0) {
            foreach( $statement->fetch_assoc() as $key => $user ){
                $results->$key = $user;
                
            }
        } else {
            //error occur when someone entered incorrect details.
            $results->error = "OOPS! You Entered Incorrect Details!";
        }
       
            $to      = $results->Email;
            $subject = 'Username and Password';
            $message = 'Hello '.$results->User_Name.', Your Password Is: '.$results->Password.'';
            $headers = 'From: cyberxau@box1228.bluehost.com' . "\r\n" .
                'Reply-To: cyberxau@box1228.bluehost.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $mail = mail($to, $subject, $message, $headers);
            
            return $results;
       
    }

    
}

$webservices = new ForgetPass();

if(!empty($_REQUEST) && (($_REQUEST['email'] != ""))){
        // Calling the register method and store the output in result variable
            //echo "register";
            $result = $webservices->forgetPass($mysqli, $_REQUEST['email']);
        }


// Converted it into JSON encode and display it 
 echo json_encode(array('results'=>$result));
?>