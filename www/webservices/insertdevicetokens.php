<?php

	class deviceToken {

		private $con;

		public function __construct(){
			$this->con = new mysqli('localhost','artworl4_demo','deep&*^art','artworl4_terance');
		}

		public function insertToken($data){
			$columns = implode(",",array_keys($data));
			$values = implode(",",array_map(function($a){return "'".$a."'";},$data));
			$query = "insert into push_device ($columns) values($values)";
			$res = $this->con->query($query);
			return $this->con->insert_id;
		}

		public function checkToken($data){
			array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
			$where = implode(' and ',$data);
			$query = "select * from push_device where $where";
			$res = $this->con->query($query);
			return $res->num_rows;
		}
	}

	$device = new deviceToken();

	if(isset($_REQUEST['device_token'])){
		$data = array(
				"Device_Token"=>$_REQUEST['device_token'],
				"Device_Type"=>$_REQUEST['device_udid'],
				"Device_UDID"=>$_REQUEST['uuid'],
				"User_ID"=>$_REQUEST['uid']
			);
		file_put_contents(dirname(__FILE__)."/deviceLog.log",print_r($_REQUEST,true));
		$exist = $device->checkToken($data);
		if(!$exist){
			$result = $device->insertToken($data);
			file_put_contents(dirname(__FILE__)."/tmplog.log",print_r($result,true));
			if(!empty($result)){
	            echo json_encode(array("response"=>$result,"error"=>0));
	        }else{
	            echo json_encode(array("response"=>"No data found","error"=>1));
	        }	
		}else{
			echo json_encode(array("response"=>"Token exist","error"=>1));
		}
		
	}



?>