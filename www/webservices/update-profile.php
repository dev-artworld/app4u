<?php
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class UpdateProfile {
    
    public function __construct() {
    } 

    
    public function updateCompany($connection, $userid, $companyname) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set CompanyName='$companyname' WHERE `User_Id` = '".$userid."'");
        $results = new stdClass();
        //fetching records from database sent it to view.
        
            //error occur when someone entered incorrect details.
          
       
        //create login user session
      
        return $results;
    }
    public function updateAddress($connection, $userid, $address) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set Address='$address' WHERE `User_Id` = '".$userid."'");
        $results = new stdClass();
        //fetching records from database sent it to view.
        
            //error occur when someone entered incorrect details.
          
      
        //create login user session
        
        return $results;
    }

public function updateCity($connection, $userid, $city) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set City='$city' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
        
        return $results;
    }

public function updateState($connection, $userid, $state) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set State='$state' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
       
        return $results;
    }

public function updateMobile($connection, $userid, $mobile) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set Mobile='$mobile' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
       
        return $results;
    }

public function updateUsername($connection, $userid, $username) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set User_Name='$username' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
            
        return $results;
    }

public function updatePassword($connection, $userid, $password) {
       $pass = md5($password);
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set Password='$pass' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
       
        return $results;
    }

public function updateEmail($connection, $userid, $email) {
       
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("UPDATE `user_details` set Email='$email' WHERE `User_Id` = '".$userid."'");
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
        //create login user session
      
        return $results;
    }



    
    


}

$webservices = new UpdateProfile();

/*if(!empty($_REQUEST) && (($_REQUEST['firstname'] != "") && ($_REQUEST['surname']!="") && ($_REQUEST['address']!="") && ($_REQUEST['postcode']!="") && ($_REQUEST['homephone']!="") && ($_REQUEST['workphone']!="") && ($_REQUEST['mobile']!="") && ($_REQUEST['email']!="") && ($_REQUEST['username']!="") && ($_REQUEST['password']!="") && ($_REQUEST['companyname']!="") && ($_REQUEST['usertype']!=""))){
        // Calling the register method and store the output in result variable
            echo "register";
            $webservices->register($mysqli, $_REQUEST['firstname'], $_REQUEST['surname'], $_REQUEST['address'], $_REQUEST['postcode'], $_REQUEST['homephone'], $_REQUEST['workphone'], $_REQUEST['mobile'], $_REQUEST['email'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['companyname'], $_REQUEST['usertype']);
        }
*/
switch ($_REQUEST['action']) {
    case 'company':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['companyname']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateCompany($mysqli, $_REQUEST['userid'], $_REQUEST['companyname']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'address':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['address']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateAddress($mysqli, $_REQUEST['userid'], $_REQUEST['address']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'city':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['city']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateCity($mysqli, $_REQUEST['userid'], $_REQUEST['city']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'state':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['state']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateState($mysqli, $_REQUEST['userid'], $_REQUEST['state']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'mobile':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['mobile']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateMobile($mysqli, $_REQUEST['userid'], $_REQUEST['mobile']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'username':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['username']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateUsername($mysqli, $_REQUEST['userid'], $_REQUEST['username']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'password':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['password']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updatePassword($mysqli, $_REQUEST['userid'], $_REQUEST['password']);
        }
        echo json_encode(array('results'=>$result));
        break;
        case 'email':
        if(!empty($_REQUEST) && ($_REQUEST['userid']!="") && ($_REQUEST['email']!="")){
        // Calling the login method and store the output in result variable
            $result = $webservices->updateEmail($mysqli, $_REQUEST['userid'], $_REQUEST['email']);
        }
        echo json_encode(array('results'=>$result));
        break;
        
        
    
   
        

    default:
        $result = $webservices->index();
        break;
}

// Converted it into JSON encode and display it 

?>