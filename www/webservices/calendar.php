<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class Calendar {
    
    public function __construct() {
   
    } 
   
    public function calendar($connection, $date) {

        $connection->select_db("artworl4_terance");

        $statement = $connection->query("SELECT StartDate FROM `user_service` WHERE DATE_FORMAT( StartDate, '%c' ) = MONTH(CURDATE())");
        $results = new stdClass();
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
            //$results->error = "OOPS! You Entered Incorrect Details!";
        }


        file_put_contents(dirname(__FILE__)."/array.log",print_r($arr , true));

        //file_put_contents(dirname(__FILE__)."/re22.log",print_r($arr , true));
        return $arr;
       
    }

    public function getServisec($connection,$uid){
        $connection->select_db("artworl4_terance");
        $query = "select * from provider_service as ps inner join user_service as us on ps.Provider_Service_Id=us.PROVIDER_sERVICE_iD where DATE_FORMAT( us.StartDate, '%c' ) = MONTH(CURDATE()) and ps.Provider_Id='$uid'";
        $result = $connection->query($query);
        $res = array();
        if($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $res[] = $row;
            }
        }
        return $res;
    }

    
}

$webservices = new Calendar();

if(isset($_REQUEST['type']) && $_REQUEST['type']=="provider"){
    $result = $webservices->getServisec($mysqli,$_REQUEST['uid']);
    if(!empty($result)){
        echo json_encode(array("response"=>$result,"error"=>0));
    }else{
        echo json_encode(array("response"=>"No service pending","error"=>1));
    }
}else{
    $result = $webservices->calendar($mysqli,$_REQUEST['date']);
    echo json_encode(array('results'=>$result));
}


// Converted it into JSON encode and display it 

?>