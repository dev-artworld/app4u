<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class ProviderDetail {
    
    public function __construct() {
    } 
   

    // Login Method
    public function providerDetail($connection, $userid) {
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT ps.Provider_Service_Id,ps.Service_Logo_Link,ps.Service_Description,ud.First_Name,ud.Surname,ud.Address,ud.city,ud.State,ud.Mobile,psp.Price,psg.Image_Link,f.Frequency_Name FROM user_details as ud INNER JOIN provider_service as ps ON ud.User_Id = ps.Provider_Id INNER JOIN provider_service_price as psp ON psp.Provider_Service_ID = ps.Provider_Service_Id INNER JOIN provider_service_gallery as psg ON psg.Provider_Service_ID = ps.Provider_Service_Id INNER JOIN frequency as f ON f.Frequency_Id = psp.Frequency_Id WHERE ud.User_Id = '$userid' ");
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


        //file_put_contents(dirname(__FILE__)."/array.log",print_r($arr , true));

        //file_put_contents(dirname(__FILE__)."/re22.log",print_r($arr , true));
        return $results;
       
    }

    
}

$webservices = new ProviderDetail();

if(!empty($_REQUEST) && ($_REQUEST['userid'] != "")){
        // Calling the register method and store the output in result variable
            
            $result = $webservices->providerDetail($mysqli,$_REQUEST['userid']);
        }



// Converted it into JSON encode and display it 
echo json_encode(array('results'=>$result));
?>