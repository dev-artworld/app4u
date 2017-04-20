<?php

	class deviceToken {

		private $con;

		public function __construct(){
			$this->con = new mysqli('localhost','artworl4_demo','deep&*^art','artworl4_terance');
		}

		public function getToken($data){
			array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
			$where = implode(' and ',$data);
			$query = "SELECT * FROM `user_service` AS us INNER JOIN provider_service AS ps ON us.PROVIDER_sERVICE_iD=ps.Provider_Service_Id INNER JOIN push_device AS pd ON ps.Provider_Id=pd.User_ID WHERE $where";
			$result = $this->con->query($query);
			$res = array();
	        if ($result->num_rows > 0) {
	            while($row = mysqli_fetch_assoc($result)){
	                $res[] = $row;
	            }
	        }
	        return $res;
		}

		public function updateServiceStat($data){
			array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
			$where = implode(' and ',$data);
			$query = "UPDATE user_service SET Status='done' WHERE $where";
			$result = $this->con->query($query);
		}
	}

	$device = new deviceToken();
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="serviceState"){
		$data = array("us.User_Service_Id"=>$_REQUEST['usid']);
		$tokens = $device->getToken($data);
		foreach ($tokens as $key => $value) {
				
			$msg=Array('message'=>'You just Completed a Service.');
			$url='https://android.googleapis.com/gcm/send';
			$fields=array(
				'registration_ids'=>Array($value['Device_Token']),
				'data'=>$msg
			);
			$headers=array(
				'Authorization: key=AIzaSyA7b51VpTCLfEMqkHVXSOb9h3H0gu6e1M4',
				'Content-Type: application/json'
			);

			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
			$result=curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result);
			if($result->success==1){
				$data = array("User_Service_Id"=>$_REQUEST['usid']);
				$device->updateServiceStat($data);
			}

		}
		if($result->success==1){
			echo json_encode(array("response"=>"Notification sent to Provider.","error"=>0));
		}
	}
?>