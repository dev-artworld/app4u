<?php
 class model {

 	private $con;

 	function __construct(){
 		$this->con = new mysqli('localhost','demo','deep&*^art','sensor');
 	}

 	public function insert($data,$table){
 		$columns = implode(",",array_keys($data));
		$values = implode(",",array_map(function($a){return "'".$a."'";},$data));
		$query = "insert into $table ($columns) values($values)";
		$result = $this->con->query($query);
		return $this->con->insert_id;
 	}

 	public function selectUser($data){
 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
		$query = "SELECT * FROM users where $where";
		$result = $this->con->query($query);
		$row=mysqli_fetch_assoc($result);
		return $row["id"];
 	}

 	public function getData(){
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
 	}

 	public function getsensor($data){
 		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "SELECT * FROM sensors WHERE $where";
 		$result=	$this->con->query($query);
 		while($row 	=	mysqli_fetch_array($result)){
			$output[] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"description" => $row['description'],
				"user_id" => $row['user_id'],
				"date" => $row['date'],
				"reading" => $row['reading']
			);
 		}
		return json_encode($output);
  	}

  	public function getalerts($data){
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "SELECT * FROM alerts WHERE $where";
 		$result=	$this->con->query($query);
 		while($row 	=	mysqli_fetch_array($result)){
			$output[] = array(
				"id" => $row['id'],
				"sensor_id" => $row['sensor_id'],
				"title"=> $row['title'],
				"message" => $row['message'],
				"sound" => $row['sound'],
				"reading" => $row['reading'],
				"user_id" => $row['user_id'],
				"date" => $row['date']
			);
 		} 			
		return $output;
  	}


  	public function deletealert($data,$table){
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
 		$query = "DELETE FROM $table WHERE  $where";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}


 	public function update($update,$data,$table){
 		array_walk($update,function(&$v,$k){ $v=$k."='".$v."'"; });
		$update = implode(' , ',$update);
		echo $update;
  		array_walk($data,function(&$v,$k){ $v=$k."='".$v."'"; });
		$where = implode(' and ',$data);
		echo $where;
 		$query = "UPDATE $table SET $update  WHERE $where";
 		$result=	$this->con->query($query);
 		return mysqli_affected_rows($this->con);
 	}
}
/*message='test',sound='test',reading=20,alerts_condition=1,title='test'
message=test,sound=test,reading=20,alerts_condition=1,title=test*/
?>
