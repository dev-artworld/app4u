<?php
header('Access-Control-Allow-Origin: *');
require_once("model.php");

	class controller {

		private $MODEL;

		public function __construct(){
			$model = new model();
			$this->MODEL = $model;
		}

		public function saveData($data,$table){
			return $this->MODEL->insert($data,$table);
		}

		public function getEmailIdIfExist($data,$table){
			return $this->MODEL->get_email_id_if_exit($data,$table);
		}


		public function selectData($where,$table){
			return $this->MODEL->select_Data($where,$table);
		}



		public function insertIntoSelect($insertFields,$cloneFields,$where,$table){
			return $this->MODEL->insert_into_select($insertFields,$cloneFields,$where,$table);
		}

		public function login($data){
			return $this->MODEL->selectUser($data);
		}
		/*public function getdata(){
			return $this->MODEL->getData();
		}*/
		public function getdevice($data){
			return $this->MODEL->getdevice($data);
		}
		public function getUser($data){
			return $this->MODEL->getUser($data);
		}
		public function deletealert($data,$table){
			return $this->MODEL->delete($data,$table);
		}
		public function deletesensor($data,$table){
			return $this->MODEL->delete($data,$table);
		}
		public function updatealerts($update,$data,$table){
			return $this->MODEL->update($update,$data,$table);
		}
		public function updatesensor($update,$data,$table){
			return $this->MODEL->update($update,$data,$table);
		}
		public function users($data){
			return $this->MODEL->allusers($data);
		}
		public function updateusers($data){
			return $this->MODEL->updateprofile($data);
		}
		public function insertmessages($data){
			return $this->MODEL->insertmessages($data);
		}
		public function deleteinvites($data){
			return $this->MODEL->deleteinvite($data);
		}
		public function messagelist(){
			return $this->MODEL->messagelist();
		}
		public function detailmessage($data){
			return $this->MODEL->detailmessage($data);
		}
		
	}

	$controller = new controller();

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="register"){

		$_data = array(
			"email"=>$_REQUEST['email'],
		);

		$_result = $controller->getEmailIdIfExist($_data,"users");

		
		if(empty($_result))
		{
			$data = array(
				"first_name"=>$_REQUEST['first_name'],
				"last_name"=>$_REQUEST['last_name'],
				"email"=>$_REQUEST['email'],
				"password"=>md5($_REQUEST['password'])
				);
			$result = $controller->saveData($data,"users");
			if(!empty($result)){
	            echo json_encode(array("response"=>$result,"error"=>0));
	        }else{
	            echo json_encode(array("response"=>"No data found","error"=>1));
	        }
        }
        else
        {
        	echo json_encode(array("message"=>"Email Address already exist","response"=>"True","error"=>0));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="checkemail"){

		$_data = array(
			"email"=>$_REQUEST['email'],
		);

		$_result = $controller->getEmailIdIfExist($_data,"users");

		if(empty($_result))
		{
			echo json_encode(array("message"=>"Valid Email Address","response"=>"true","error"=>0));
		} else {
			echo json_encode(array("message"=>"Email Address already exist","response"=>"false","error"=>1));
		}

	}	

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="login"){
		$data = array(
			"first_name"=>$_REQUEST['username'],
			"password"=>md5($_REQUEST['password'])
			);
		$result = $controller->login($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="add-device"){
		$data = array(
			"device_name" => $_REQUEST['device_name'],
			"device_id" => $_REQUEST['device_id'],
			"user_id" => $_REQUEST["user_id"],
			"device_icon" => "image.jpg"
		);
		$result = $controller->saveData($data,"devices");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getdevice"){
		$data = array(
			"user_id" => $_REQUEST["user_id"]
		);
		if(isset($_REQUEST['id'])){
			$data = array(
				"user_id"=>$_REQUEST["user_id"],
				"id"=>$_REQUEST["id"]
			);
		}

		echo $result = $controller->getdevice($data);
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getuser"){
		$data = array(
			"id"=>$_REQUEST["user_id"]
		);
		$result = $controller->getUser($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found ","error"=>1));
        }
	}

	
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="add-alerts"){

		$data = array(
			"sensor_id"=>$_REQUEST['sensor_id'],
			"sound"=>$_REQUEST['sound'],
			"title"=>$_REQUEST['title'],
			"reading"=>$_REQUEST['reading'],
			"message"=>$_REQUEST['message'],
			"user_id"=>$_REQUEST['user_id'],
			"alerts_condition"=>$_REQUEST['condition']
		);		
		$result = $controller->saveData($data,"alerts");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}


	if(isset($_REQUEST['action']) && $_REQUEST['action']=="deletealert"){
		$data = array(
			"id"=>$_REQUEST['id']
			);
		$result = $controller->deletealert($data,"alerts");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}


	if(isset($_REQUEST['action']) && $_REQUEST['action']=="deletesensor"){
		$data = array(
			"id"=>$_REQUEST['id']
			);
		$result = $controller->deletesensor($data,"sensors");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}


	if(isset($_REQUEST['action']) && $_REQUEST['action']=="updatealerts"){
		$update = array(
			"sound"=>$_REQUEST['sound'],
			"title"=>$_REQUEST['title'],
			"reading"=>$_REQUEST['reading'],
			"message"=>$_REQUEST['message'],
			"alerts_condition"=>$_REQUEST['condition']
			);
		$data =	array(
				"id"=>$_REQUEST['id'],
			);
		$result = $controller->updatealerts($update,$data,"alerts");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="updatesensor"){
		$update = array(
			"name"=>$_REQUEST['name'],
			"description"=>$_REQUEST['description']
			);
		$data =	array(
				"id"=>$_REQUEST['id'],
			);
		$result = $controller->updatesensor($update,$data,"sensors");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="allusers"){
		$data = array(
			"id"=>$_REQUEST['id']
			);
		$result = $controller->users($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="addgroup"){

		$data = array(
			"user_id"=>$_REQUEST["user_id"],
			"group_name"=>$_REQUEST["group_name"]
		);

		$result = $controller->saveData($data,"groups");

		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
		
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="add_group_contacts"){

		$data = array(
			"group_id"=>$_REQUEST["gid"],
			"device_id"=>$_REQUEST["did"]
		);

		$result = $controller->saveData($data,"group_contacts");
		
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
		
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getgroups"){

		$data = array(
			"user_id"=>$_REQUEST["uid"]
		);

		$result = $controller->selectData($data,"groups");
		
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
		
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="updateuser"){


		$data = array(
			"username"=>$_REQUEST['username'],
			"email"=>$_REQUEST['email'],
			"password"=>md5($_REQUEST['password']),
            "id"=>$_REQUEST['user_id']
			);

		print_r($_REQUEST['password']);

		print_r($data);

		$result = $controller->updateusers($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="deleteinvite"){
		$data = array(
			"id"=>$_REQUEST['id']
			);
		$result = $controller->deleteinvites($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="insertmessage"){
		$data = array(
			"name"=>$_REQUEST['name'],
			"message"=>$_REQUEST['message']
		     );
		
		$result = $controller->insertmessages($data);
		if(!empty($result)){
			$to = "harpreet@retouchingwork.org";
			$subject = "Message Email";
			$txt = "Hello world! This is testing message!";
			$headers = "From: message@example.com" . "\r\n" .
			"CC: retouchingwork@example.com";

			mail($to,$subject,$txt,$headers);

            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="messagelist"){
		$result = $controller->messagelist();
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="detailmessage"){
		$data = array(
			"id"=>$_REQUEST['id']
			);
		$result = $controller->detailmessage($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}
?>
