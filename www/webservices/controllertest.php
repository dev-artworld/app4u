<?php
header('Access-Control-Allow-Origin: *');
require_once("modeltest.php");

	class controller {

		private $MODEL;

		public function __construct(){
			$model = new model();
			$this->MODEL = $model;
		}

		public function saveData($data,$table){
			return $this->MODEL->insert($data,$table);
		}

		public function login($data){
			return $this->MODEL->selectUser($data);
		}
		public function getdata(){
			return $this->MODEL->getData();
		}
		public function getsensor($data){
			return $this->MODEL->getsensor($data);
		}
		public function getalerts($data){
			return $this->MODEL->getalerts($data);
		}
		public function deletealert($data,$table){
			return $this->MODEL->deletealert($data,$table);
		}
		public function updatealerts($update,$data,$table){
			return $this->MODEL->update($update,$data,$table);
		}
		public function updatesensor($update,$data,$table){
			return $this->MODEL->update($update,$data,$table);
		}

	}

	$controller = new controller();

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="register"){
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

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="login"){
		$data = array(
			"email"=>$_REQUEST['username'],
			"password"=>md5($_REQUEST['password'])
			);
		$result = $controller->login($data);
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="add-sensor"){
		$data = array(
			"name"=>$_REQUEST['name'],
			"description"=>$_REQUEST['description'],
			"reading"=>$_REQUEST['reading'],
			"user_id"=>$_REQUEST['user_id']
		);
		$result = $controller->saveData($data,"sensors");
		if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getdata"){

		echo $result = $controller->getdata();
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getsensor"){
		$data = array(
			"user_id"=>$_REQUEST["user_id"]
		);
		if(isset($_REQUEST['id'])){
			$data = array(
				"user_id"=>$_REQUEST["user_id"],
				"id"=>$_REQUEST["id"]
			);
		}
		/*if(!empty($result)){
            echo json_encode(array("response"=>$result,"error"=>0));
        }else{
            echo json_encode(array("response"=>"No data found","error"=>1));
        }*/
		echo $result = $controller->getsensor($data);
	}

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="getalerts"){
		$data = array(
			"sensor_id"=>$_REQUEST["id"],
			"user_id"=>$_REQUEST["user_id"]
		);
		$result = $controller->getalerts($data);
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
?>
