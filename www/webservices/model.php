<?php
 class model {

 	private $con;

 	function __construct(){
 		$this->con = new mysqli('localhost','cyberxau_demo','deep&*^art','cyberxau_app4u');
 	}
 	// Function For insert data
 	public function insert($data,$table){
 		$columns = implode(",",array_keys($data));
		$values = implode(",",array_map(function($a){return "'".$a."'";},$data));
		$query = "insert into $table ($columns) values($values)";
		$result = $this->con->query($query);
		return $this->con->insert_id;
 	}

 	public function select_data($data,$table){

 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
		$query = "SELECT * FROM $table WHERE $where";
		$result = $this->con->query($query);
		$output= array();
		while($row 	=	mysqli_fetch_assoc($result)){
			$output[] = array(
				"id" => $row['id'],
				"group_name" => $row['group_name']				
			);
 		}
		return $output;
 	}

 	public function get_email_id_if_exit($data,$table){

 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
		$query = "SELECT * FROM $table WHERE $where";
		$result = $this->con->query($query);
		$row=mysqli_fetch_assoc($result);
		return $row["id"];
 	}

 	public function insert_into_select($insertFields,$cloneFields,$where,$table){
 		$columns = implode(",", $insertFields);
 		$cloneColumns = implode(",", $cloneFields);
 		array_walk($where,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$where);
 		 $query = "INSERT INTO $table ($columns) SELECT $cloneColumns from $table WHERE $where";
 		 $result = $this->con->query($query);
 		 return $this->con->insert_id;
 	}

 	public function selectUser($data){
 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
		$query = "SELECT * FROM users where $where";
		$result = $this->con->query($query);
		$row = mysqli_fetch_assoc($result);
		return $row["id"];
 	}

 	/*public function getData(){
 		$query ="SELECT id,name,description FROM sensors ";
 		$result	=	$this->con->query($query);
 		$index=0;

 		while($row 	=	mysqli_fetch_assoc($result))
 		{
 			$output[$index] = array("sensor"=>array("name" => $row['name'],
	                "description" => $row['description'])
            );

 			$subquery ="SELECT message,sound,reading FROM sensor_action WHERE sensor_id = ".$row['id'];
			$res=	$this->con->query($subquery);
			$actions= array();
			while($rows =mysqli_fetch_assoc($res))
			{ 
				array_push($actions, array("message" => $rows['message'],"sound" => $rows['sound'],"reading" => $rows['reading']));
			}
			$output[$index]["actions"] = $actions;
			$index++;
 		}
		return json_encode($output);
 	}*/

 	public function getdevice($data){
 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "SELECT * FROM devices WHERE $where";
 		$result=	$this->con->query($query);
 		while($row 	=	mysqli_fetch_array($result)){
			$output[] = array(
				"id" => $row['ID'],
				"device_name" => $row['device_name'],
				"device_id" => $row['device_id'],
				"user_id" => $row['user_id'],
				"device_icon" => $row['device_icon'],
				"date" => $row['date']
				
			);
 		}
		return json_encode($output);
  	}

  	public function getUser($data){
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "SELECT * FROM users WHERE $where";
 		$result=	$this->con->query($query);
 		while($row 	=	mysqli_fetch_array($result)){
			$output[] = array(
				"id" => $row['id'],
				"first_name" => $row['first_name'],
				"last_name"=> $row['last_name'],
				"email" => $row['email'],
				"password" => $row['password'],
				"date" => $row['date']
			);
 		} 			
		return $output;
  	}


  	public function delete($data,$table){
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "DELETE FROM $table WHERE  $where";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}


 	public function update($update,$data,$table){
 		array_walk($update,function(&$v,$k){ $v=$k."='".$v."'"; });
		$update = implode(' , ',$update);
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "UPDATE $table SET $update  WHERE $where";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}


 	public function allusers($data){
 		array_walk($data,function(&$v,$k){ $v=$k."!='".$v."'"; });
		$where = implode(' and ',$data);
		$query = "SELECT * FROM users where $where";
		$result = $this->con->query($query);
		while($row=mysqli_fetch_assoc($result))
		{
		$output[] = array(
				"id" => $row['id'],
				"first_name" => $row['first_name'],
				"last_name"=> $row['last_name'],
				"email" => $row['email']
			);
 		} 			
		return $output;
	}

	public function updateprofile($data){
 		
 		$name = $data['username'];
 		$email = $data['email'];
 		$id = $data['id'];
 		$password = $data['password'];
		
 		$query = "UPDATE users SET first_name='$name', email='$email', password='$password' WHERE id='$id'";
 		
 		print_r($query);

 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}

 	public function deleteinvite($data){
 		
 		$id = $data['id'];
		
 		$query = "DELETE FROM `groups` WHERE id='$id'";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}
 	public function insertmessages($data){
 		
 		$name = $data['name'];
 		$message = $data['message'];
 		$query = "INSERT INTO `messages` (name, message) VALUES ('$name','$message')";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}
 		public function messagelist(){
 		$query = "SELECT * FROM `messages`";
 		$result=	$this->con->query($query);
 		while($row=mysqli_fetch_assoc($result))
		{
		$output[] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"message"=> $row['message']
			);
 		} 			
		return $output;
 	}
 	public function detailmessage($data){
 		$id = $data['id'];
 		$query = "SELECT * FROM `messages` WHERE id='$id'";
 		$result=	$this->con->query($query);
 		while($row=mysqli_fetch_assoc($result))
		{
		$output[] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"message"=> $row['message']
			);
 		} 			
		return $output;
 	}
}
?>
