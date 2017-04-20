<?php

	class deviceToken {

		private $con;

		public function __construct(){
			$this->con = new mysqli('localhost','artworl4_demo','deep&*^art','artworl4_terance');
		}

		public function getToken(){
			
			$query = "SELECT * FROM `user_service` AS us INNER JOIN push_device AS pd ON us.User_ID=pd.User_ID WHERE date(us.StartDate)>CURDATE() and us.Status='pending'";
			$result = $this->con->query($query);
			$res = array();
	        if ($result->num_rows > 0) {
	            while($row = mysqli_fetch_assoc($result)){
	                $res[] = $row;
	            }
	        }
	        return $res;
		}

		public function providerToken(){

			$query = "SELECT pd.Device_Token,ud.User_Name FROM `user_service` AS us INNER JOIN provider_service AS ps ON us.PROVIDER_sERVICE_iD=ps.Provider_Service_Id INNER JOIN push_device AS pd ON ps.Provider_Id=pd.User_ID INNER JOIN user_details as ud ON us.User_ID=ud.User_Id WHERE us.Status='pending' and date(us.StartDate)<CURDATE()";
			//$query="SELECT pd.Device_Token,ud.User_Name FROM `user_service` AS us INNER JOIN provider_service AS ps ON us.PROVIDER_sERVICE_iD=ps.Provider_Service_Id INNER JOIN push_device AS pd ON ps.Provider_Id=pd.User_ID INNER JOIN user_details as ud ON us.User_ID=ud.User_Id WHERE us.StartDate>NOW() and us.Status='pending'";
			$result = $this->con->query($query);
			$res = array();
	        if ($result->num_rows > 0) {
	            while($row = mysqli_fetch_assoc($result)){
	                $res[] = $row;
	            }
	        }
	        return $res;
		}

		public function updateServiceDates($data,$StartDate){
			array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
			$where = implode(' and ',$data);
			$NextDueDate = date("Y-m-d",strtotime("+1 month",strtotime($StartDate)));
			$query = "UPDATE user_service SET StartDate='$StartDate',NextDueDate='$NextDueDate' WHERE $where";
			$result = $this->con->query($query);
		}
	}

	$device = new deviceToken();

	$tokens = $device->getToken();
	$provider_token = $device->providerToken();
	
	if(!empty($tokens)){
		foreach ($tokens as $key => $value) {
			$ServiceDate = strtotime($value['StartDate']);
			if($ServiceDate>=time() && $ServiceDate<=strtotime("+1 day",time())){

				$url='https://android.googleapis.com/gcm/send';
				$fields=array(
					'registration_ids'=>Array($value['Device_Token']),
					'data'=>Array('message'=>"Your service is due tomorrow.")
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
					$data = array("User_Service_Id"=>$value['User_Service_Id']);
					$device->updateServiceDates($data,$value['NextDueDate']);
				}
			}
		}
	}

	if(!empty($provider_token)){
		foreach ($provider_token as $key => $value) {
				
			$msg = "You have Missed ".$value['User_Name']."'s Service Today.";
			$url='https://android.googleapis.com/gcm/send';
			$fields=array(
				'registration_ids'=>Array($value['Device_Token']),
				'data'=>Array('message'=>$msg)
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
		}
	}



?>