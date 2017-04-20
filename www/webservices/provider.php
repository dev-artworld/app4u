<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class Provider {
    
    public function __construct() {
    } 
   

    // Login Method
    public function provider($connection,$service,$state,$city,$price) {
        $price = explode("-",$price);
        $connection->select_db("artworl4_terance");
        //$statement = $connection->query("SELECT ud.User_Id,ps.Service_Logo_Link,ps.Service_Description,ud.First_Name,ud.Surname,psp.Price FROM user_details as ud INNER JOIN provider_service as ps ON ud.User_Id = ps.Provider_Id INNER JOIN provider_service_price as psp ON psp.Provider_Service_ID = ps.Provider_Service_Id WHERE ud.UserType = '$usertype' and ud.State = '$state' and ud.City = '$city' and psp.Price = '$price'");
        $query = "select * from provider_service as ps inner join services as s on ps.Service_ID=s.Service_Id inner join user_details as ud on ps.Provider_Id=ud.User_Id inner join provider_service_price as psp on ps.Provider_Service_Id=psp.Provider_Service_ID where ps.Service_ID='$service' and ps.Service_State='$state' and ps.Service_City='$city' and ud.UserType='provider' and psp.Price BETWEEN '$price[0]' and '$price[1]' group by ps.Provider_Service_Id";
        $statement = $connection->query($query);
        if ($statement->num_rows > 0) {
           $arr = array();
            while( $row = $statement->fetch_assoc() ){
                $results = new stdClass();
                foreach ($row as $key => $value) {
                    $results->$key = $value;
                }                
                $arr[] = $results; 
            }
        }else{         
            $results->error = "OOPS! You Entered Incorrect Details!";
        }
        return $arr;       
    }    
}

$webservices = new Provider();

if(isset($_REQUEST['service']) && isset($_REQUEST['state']) && isset($_REQUEST['city']) && isset($_REQUEST['price'])){
    $result = $webservices->provider($mysqli,$_REQUEST['service'],$_REQUEST['state'],$_REQUEST['city'],$_REQUEST['price']);
    if(!empty($result)){
        echo json_encode(array("response"=>$result,"error"=>0));
    }else{
        echo json_encode(array("response"=>"No data found","error"=>1));
    }
}
?>