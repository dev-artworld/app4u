<?php
header("Access-Control-Allow-Origin: *");
session_start();

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');

class WebServices {
    
    public function __construct() {
    } 

    // Login Method
    public function login($connection, $usernameField, $passwordField) {
        $password = $passwordField;
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * FROM `user_details` WHERE `Email` = '$usernameField' AND `Password` = '$password'");
		file_put_contents(dirname(__FILE__)."/log12.txt","SELECT * FROM `user_details` WHERE `Email` = '$usernameField' AND `Password` = '$password'");
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
        $_SESSION["userid"] = $results->User_Id;
        $_SESSION['userdata'] = $results;
        return $results;
    }

    // Register Method
    public function register($connection,$usernameField,$passwordField,$companyname,$usertype,$state,$address,$mobile,$email) {
        $password = $passwordField;
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("INSERT INTO `user_details`(`User_Name`, `Password`, `CompanyName`, `service_type`, `State`, `Address`, `Mobile`, `Email`,`UserType`) VALUES ('$usernameField','$password','$companyname','$usertype','$state','$address','$mobile','$email','consumer')");
        //Insert Data Into Database

        $records = array('Success' => 'User Has Been Successfully Registered');
        
        return $records;
        
    }

    public function company_register($connection,$company,$service_type,$street_address,$city,$state,$contact_number,$username,$password,$email) {
        $connection->select_db("artworl4_terance");
        $query = "INSERT INTO `user_details`(`CompanyName`,`service_type`, `Address`, `City`, `State`, `Mobile`, `User_Name`, `Password`, `Email`,`UserType`) VALUES ('$company','$service_type','$street_address','$city', '$state','$contact_number','$username','$password', '$email','provider')";
        $statement = $connection->query($query);
        file_put_contents(dirname(__FILE__)."/query.log",$query);
        $records = 'Company has been successfully registered';
        return $records;
    }

    public function emailAlreadyExist($connection,$email){
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * FROM `user_details` WHERE `Email` = '".$email."'");
        $results = new stdClass();
        //fetching records from database sent it to view.
        if ($statement->num_rows > 0)
        {
           //echo "exist";
            $exist = array('Exist' => 'Email Already Exist, Please Use Another Email Id');
            return $exist;
        }
        else
        {
            $exist = array('Exist' => 'Email Exist');
            return $exist;
        }
        //return $exist;
    }
    public function userAlreadyExist($connection,$username){
        $connection->select_db("artworl4_terance");
        $statement = $connection->query("SELECT * FROM `user_details` WHERE `User_Name` = '".$username."'");
        $results = new stdClass();
        //fetching records from database sent it to view.
        if ($statement->num_rows > 0)
        {
           //echo "exist";
            $exist = array('user' => 'Username Already Exist, Please Use Another Username');
            return $exist;
        }
        else
        {
            $exist = array('user' => 'Username Exist');
            return $exist;
        }
        //return $exist;
    }

    public function providerServicesbyDate($connection,$uid,$date){
        $connection->select_db("artworl4_terance");
        $query = "SELECT * FROM `user_service` as us inner join user_details as ud on us.User_Id=ud.User_Id inner join provider_service as ps on us.PROVIDER_sERVICE_iD=ps.Provider_Service_Id inner join services as s on ps.Service_ID=s.Service_Id where ps.Provider_Id='$uid' and us.StartDate='$date'";
        $result = $connection->query($query);
        $res = array();
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $res[] = $row;
            }
        }
        return $res;
    }

    public function providerServices($connection,$uid){
        $connection->select_db("artworl4_terance");
        $query = "SELECT * FROM `provider_service` as ps inner join services as s on ps.Service_ID=s.Service_Id where ps.Provider_Id='$uid'";
        $result = $connection->query($query);
        $res = array();
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $res[] = $row;
            }
        }
        return $res;
    }

    public function deleteService($connection,$sid,$pid){   
        $connection->select_db("artworl4_terance");
        $connection->query("SET FOREIGN_KEY_CHECKS=0");
        $query = "delete ps,psg,psp,us from services as s left join provider_service as ps on s.Service_Id=ps.Service_ID left join provider_service_gallery as psg on ps.Provider_Service_Id=psg.Provider_Service_ID left join provider_service_price as psp on ps.Provider_Service_Id=psp.Provider_Service_ID left join user_service as us on ps.Provider_Service_Id=us.PROVIDER_sERVICE_iD where s.Service_Id='$sid' and ps.Provider_Id='$pid'";
        $result = $connection->query($query);
        $connection->query("SET FOREIGN_KEY_CHECKS=1");
        if($result) {
          return "Deleted Successfully";
        }
        return 0;
    }

    public function getServiceDetail($connection,$uid,$sid){
        $connection->select_db("artworl4_terance");
        $query = "SELECT * FROM provider_service as ps inner join services as s on ps.Service_ID=s.Service_Id where ps.Provider_Id='$uid' and ps.Service_ID='$sid'";
        $result = $connection->query($query);     

        if($result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $res['service_details'][] = $row;
            }
        }
        $Provider_Service_Id = $res['service_details'][0]['Provider_Service_Id'];
        $query = "select * from provider_service_gallery where Provider_Service_ID='$Provider_Service_Id'";
        $result = $connection->query($query);        
        if($result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $res['gallery'][] = $row;
            }
        }
        $query = "select * from provider_service_price as psp inner join frequency as f on psp.Frequency_Id=f.Frequency_Id where psp.Provider_Service_ID='$Provider_Service_Id'";
        $result = $connection->query($query);        
        if($result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $res['price'][] = $row;
            }
        }
        
        return $res;
    }

    public function updateServiceDetails($connection,$fid,$fval,$pid,$pval){
        $connection->select_db("artworl4_terance");
        $query = "update frequency set Frequency_Name='$fval' where Frequency_Id = '$fid'";
        $result = $connection->query($query);
        if($result){
            $query2 = "update provider_service_price set Price='$pval' where Provider_Service_Price_ID = '$pid'";
            $result2 = $connection->query($query2);
            if($result2){
                return "updated Successfully";
            }else
            return 0;
        }else{
            return 0;
        }
    }

    public function getServices($connection){
        $connection->select_db("artworl4_terance");
        $query = "select * from services";
        $result = $connection->query($query);
        $res = array();
        if($result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $res[] = $row;
            }
        }
        return $res;  
    }

    public function addService($connection,$uid,$service,$service_logo,$company,$address,$state,$city,$description,$price1,$price2,$price3,$gallery){
        $connection->select_db("artworl4_terance");
        $query = "insert into provider_service (Provider_Id,Service_ID,Service_Logo_Link,Service_Description,Service_Address,Service_State,Service_City,Service_Company) values('$uid','$service','$service_logo','$description','$address','$state','city','$company')";
        $result1 = $connection->query($query);
        $Provider_Service_Id = $connection->insert_id;
        foreach ($gallery as $key => $value) {
            $query = "insert into provider_service_gallery (Provider_Service_ID,Image_Link) values('$Provider_Service_Id','$value')";
            $result2 = $connection->query($query);
        }
        $query = "insert into provider_service_price (Provider_Service_ID,Frequency_Id,Price) values('$Provider_Service_Id','1','$price1'),('$Provider_Service_Id','2','$price2'),('$Provider_Service_Id','3','$price3')";
        $result3 = $connection->query($query);
        if($result1 && $result2 && $result3){
            return "Service Added Successfully";
        }else{
            return 0;
        }
    }

    public function subscribeService($connection,$psid,$sdate,$fid,$edate,$uid){

        $connection->select_db("artworl4_terance");
        $query = "insert into user_service (PROVIDER_sERVICE_iD,StartDate,Frequency_ID,NextDueDate,User_ID,Status) VALUES('$psid','$sdate','$fid','$edate','$uid','pending')";
        $result = $connection->query($query);
        if($result){
            $query = "select Email from user_details where User_Id='$uid'";
            $result = $connection->query($query);
            $row = mysqli_fetch_assoc($result);
            $consumer_email = $row["Email"];

            $query = "select ud.Email from user_details as ud inner join provider_service as ps on ud.User_Id=ps.Provider_Id where ps.Provider_Service_Id='$psid'";
            $result = $connection->query($query);
            $row = mysqli_fetch_assoc($result);
            $provider_email = $row["Email"];
            $headers = "From: ".$consumer_email."\r\n";
            mail($provider_email,"Subscrive Service","Hi I just subscribe your service",$headers);
            return "The email is sent to Provider for approval";
        }else{
            return 0;
        }

    }

    public function subscriberList($connection,$uid,$sid){
        $connection->select_db("artworl4_terance");
        $query = "SELECT * FROM user_service as us inner join provider_service as ps on us.PROVIDER_sERVICE_ID=ps.Provider_Service_Id inner join user_details as ud on ud.User_Id=us.User_ID where ps.Provider_Id='$uid' and ps.Service_ID='$sid' and us.Approved!=1";
        $result = $connection->query($query);
        $res = array();
        if($result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $res[] = $row;
            }
        }
        return $res;
    }

    public function approveSubscription($connection,$usid){
        $startDate = date("Y-m-d",strtotime("+7 days",time()));
        $NextDueDate = date("Y-m-d",strtotime("+1 month +7 days",time()));
        $connection->select_db("artworl4_terance");
        $query = "UPDATE user_service set Approved=1,StartDate='$startDate',NextDueDate='$NextDueDate' where User_Service_Id='$usid'";
        $result = $connection->query($query);
        if($result){
            return "Request Approved";
        }else{
            return 0;
        }
    }

}

$webservices = new WebServices();

/*if(!empty($_REQUEST) && (($_REQUEST['firstname'] != "") && ($_REQUEST['surname']!="") && ($_REQUEST['address']!="") && ($_REQUEST['postcode']!="") && ($_REQUEST['homephone']!="") && ($_REQUEST['workphone']!="") && ($_REQUEST['mobile']!="") && ($_REQUEST['email']!="") && ($_REQUEST['username']!="") && ($_REQUEST['password']!="") && ($_REQUEST['companyname']!="") && ($_REQUEST['usertype']!=""))){
        // Calling the register method and store the output in result variable
            echo "register";
            $webservices->register($mysqli, $_REQUEST['firstname'], $_REQUEST['surname'], $_REQUEST['address'], $_REQUEST['postcode'], $_REQUEST['homephone'], $_REQUEST['workphone'], $_REQUEST['mobile'], $_REQUEST['email'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['companyname'], $_REQUEST['usertype']);
        }
*/
switch ($_REQUEST['action']) {
    case 'login':
        if(!empty($_REQUEST) && (($_REQUEST['username'] != "") && ($_REQUEST['password']!=""))){
        // Calling the login method and store the output in result variable
            $result = $webservices->login($mysqli, $_REQUEST['username'], $_REQUEST['password']);
        }
        echo json_encode(array('results'=>$result));
        break;
    
    case 'register':
        if(!empty($_REQUEST) && ($_REQUEST['username']!="") && ($_REQUEST['password']!="") && ($_REQUEST['Company_Name']!="") && ($_REQUEST['Service_Type']!="") && ($_REQUEST['State']!="") && ($_REQUEST['Street_Address']!="") && ($_REQUEST['Contact_Number']!="") && ($_REQUEST['Email']!="")){
        // Calling the register method and store the output in result variable
           $already = $webservices->emailAlreadyExist($mysqli, $_REQUEST['Email']);
           $alreadyuser = $webservices->userAlreadyExist($mysqli, $_REQUEST['username']);
        if($already["Exist"] != "Email Exist")
        {
            echo "Email Already Exist, Please Use Another Email Id";
        }
        else if($alreadyuser["user"] != "Username Exist")
        {
            echo "Username Already Exist, Please Use Another Username";
        }
        else
        {
            $result = $webservices->register($mysqli, $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['Company_Name'], $_REQUEST['Service_Type'], $_REQUEST['State'], $_REQUEST['Street_Address'], $_REQUEST['Contact_Number'], $_REQUEST['Email']);
        }

        }
        echo json_encode(array('results'=>$result));
        break;
        
    case 'company_register':
        if(!empty($_REQUEST) && ($_REQUEST['company']!="") && ($_REQUEST['service_type']!="") && ($_REQUEST['street_address']!="") && ($_REQUEST['city']!="") && ($_REQUEST['state']!="") && ($_REQUEST['contact_number']!="") && ($_REQUEST['username']!="") && ($_REQUEST['password']!="") && ($_REQUEST['email']!="")){
        // Calling the register method and store the output in result variable
           $already = $webservices->emailAlreadyExist($mysqli, $_REQUEST['email']);
           $alreadyuser = $webservices->userAlreadyExist($mysqli, $_REQUEST['username']);
        if($already["Exist"] != "Email Exist"){
            $result="Email Already Exist, Please Use Another Email Id";
            echo json_encode(array("response"=>$result,"error"=>1));
        }else if($alreadyuser["user"] != "Username Exist"){
            $result="Username Already Exist, Please Use Another Username";
            echo json_encode(array("response"=>$result,"error"=>1));
        }else{
            $result = $webservices->company_register($mysqli, $_REQUEST['company'], $_REQUEST['service_type'], $_REQUEST['street_address'], $_REQUEST['city'], $_REQUEST['state'], $_REQUEST['contact_number'], $_REQUEST['username'], $_REQUEST['password'],$_REQUEST['email']);
            echo json_encode(array("response"=>$result,"error"=>0));
        }
        }else{
            echo json_encode(array("response"=>"Please fill required fileds","error"=>1));
        }
        break;
    case "provider-services":
        if(isset($_REQUEST['uid']) && isset($_REQUEST['date'])){
            $result = $webservices->providerServicesbyDate($mysqli,$_REQUEST['uid'],$_REQUEST['date']);    
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }

    break;
    case "provider-services-list":
        if($_REQUEST['uid']!=""){
            $result = $webservices->providerServices($mysqli,$_REQUEST['uid']);    
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }

    break;
    case "delete-service":
        if(isset($_REQUEST['sid']) && isset($_REQUEST['pid'])){
            $result = $webservices->deleteService($mysqli,$_REQUEST['sid'],$_REQUEST['pid']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    case "service_details":
        if(isset($_REQUEST['uid']) && isset($_REQUEST['sid'])){
            $result = $webservices->getServiceDetail($mysqli,$_REQUEST['uid'],$_REQUEST['sid']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    case "update-service-details":
        if(isset($_REQUEST['fid']) && isset($_REQUEST['fval']) && isset($_REQUEST['pid']) && isset($_REQUEST['pval'])){
            $result = $webservices->updateServiceDetails($mysqli,$_REQUEST['fid'],$_REQUEST['fval'],$_REQUEST['pid'],$_REQUEST['pval']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    case "add-service":
        if(isset($_REQUEST['uid'])){
            $result = $webservices->addService($mysqli,$_REQUEST['uid'],$_REQUEST['service'],$_REQUEST['service_logo'],$_REQUEST['company'],$_REQUEST['address'],$_REQUEST['state'],$_REQUEST['city'],$_REQUEST['description'],$_REQUEST['price1'],$_REQUEST['price2'],$_REQUEST['price3'],$_REQUEST['gallery']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"Operation Failed","error"=>1));
            }
        }
    break;
    case "get-services":
        if(isset($_REQUEST['uid'])){
            $result = $webservices->getServices($mysqli);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    case "subscribe-service":
    if(isset($_REQUEST['uid'])){
        $result = $webservices->subscribeService($mysqli,$_REQUEST['psid'],$_REQUEST['sdate'],$_REQUEST['fid'],$_REQUEST['edate'],$_REQUEST['uid']);
        if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
    }
    break;
    case "get-subscriber-list":
        if(isset($_REQUEST['uid'])){
            $result = $webservices->subscriberList($mysqli,$_REQUEST['uid'],$_REQUEST['sid']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    case "approve-subscription":
        if(isset($_REQUEST['usid'])){
            $result = $webservices->approveSubscription($mysqli,$_REQUEST['usid']);
            if(!empty($result)){
                echo json_encode(array("response"=>$result,"error"=>0));
            }else{
                echo json_encode(array("response"=>"No data found","error"=>1));
            }
        }
    break;
    default:
        $result = $webservices->index();
        break;
}

// Converted it into JSON encode and display it 

?>