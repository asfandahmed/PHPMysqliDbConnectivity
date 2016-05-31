<?php
define('HOST', 'hostname');
define('USER', 'username');
define('PASS', 'password');
define('DBNAME', 'database');

class Database{
	private $mysqli = NULL;
	function __construct(){
		$this->mysqli = new mysqli(HOST,USER,PASS,DBNAME);
		if($this->mysqli->connect_errno){
			echo "Sorry, this website is experiencing problems.\n";
		    echo "Error: Failed to make a MySQL connection, here is why: \n";
		    echo "Errno: " . $mysqli->connect_errno . "\n";
		    echo "Error: " . $mysqli->connect_error . "\n";
			exit();
		}
	}
	public function raw_query($sql)
	{
		$result = NULL;
		try{
			$result = $this->mysqli->query($sql);	
		}
		catch (Exception $e) {
			echo '<p>'.$e->getMessage().'</p>';
		}
		return $result;
	}
	public function get($tbl_name, $where=NULL){
		$rows = NULL;
		$sql = "SELECT * FROM " . $tbl_name;
		if($where != NULL){
			$sql .= " WHERE ".key($where)."=";
			if(is_numeric(reset($where)))
				$sql.=reset($where);
			else
				$sql.="'".$this->mysqli->real_escape_string(reset($where))."'";
		}
		$sql.=" LIMIT 1";
		try {
			if($res = $this->mysqli->query($sql)){
				while ($row = $res->fetch_assoc()) {
				  $rows[] = $row;
				}
				$res->close();
			}	
		} catch (Exception $e) {
			echo '<p>'.$e->getMessage().'</p>';
		}
		return $rows;
	}
	public  function get_all($tbl_name, $fields=array(), $where=NULL, $mixed=NULL){
		$rows = NULL;
		$sql = "SELECT ";

		if($fields==NULL)
			$sql .= "*";
		else{
			foreach ($fields as $value) 
				$sql .= $value." ";
		}
		$sql.= " FROM ".$tbl_name." ";
		if($where != NULL)
		{
			$sql.="WHERE ".key($where)."=";
			if(is_numeric(reset($where)))
				$sql.=reset($where);
			else
				$sql.= "'" . $this->mysqli->real_escape_string(reset($where)) . "'";
		}
		if($mixed != NULL)
		{
			if(isset($mixed["limit"]))
				$sql.=" LIMIT ".$mixed["limit"];
			if(isset($mixed["offset"]))
				$sql.=" LIMIT 0,".$mixed["offset"];
			if(isset($mixed["offset"]) && isset($mixed["limit"]))
				$sql.=",".$mixed["offset"];
		}
		try {
			if($res = $this->mysqli->query($sql)) {
				while ($row = $res->fetch_assoc()) {
				  $rows[] = $row;
				}
				$res->close();
			}	
		} catch (Exception $e) {
			echo '<p>'.$e->getMessage().'</p>';
		}
		return $rows;
	}
	public  function insert($tbl_name,$key_val=array()){
		$keys=NULL;
		$vals=NULL;
		foreach ($key_val as $key => $value) {
			$keys .= ",{$key}";
			if(is_string($value))
				$vals .= ",'".$this->mysqli->real_escape_string($value)."'";
			else
				$vals .= ",".$this->mysqli->real_escape_string($value);
		}
		$keys = substr($keys, 1);
		$vals = substr($vals, 1);
		$sql = "INSERT INTO {$tbl_name}($keys) VALUES({$vals})";
		if($this->mysqli->query($sql))
		{
			return $this->mysqli->insert_id;
		}
		echo $sql;
		return FALSE;
	}
	public  function update($tbl_name,$key_val=array(),$where){
		$sql = "UPDATE {$tbl_name} SET ";
		foreach ($key_val as $key => $value) {
		 	if(is_string($value))
		 		$sql.= $key."='".$this->mysqli->real_escape_string($value)."',";
		 	else
		 		$sql.= $key."=".$this->mysqli->real_escape_string($value).",";
		 }
		$sql = rtrim($sql,",");
		$sql.= " WHERE ".key($where)."=";
		if(is_numeric(reset($where)))
			$sql.=$this->mysqli->real_escape_string(reset($where));
		else
			$sql.="'".$this->mysqli->real_escape_string(reset($where))."'";
		if($this->mysqli->query($sql))
		{
			if($this->mysql->effected_rows()>0)
				return $this->mysql->effected_rows();
		}
		return FALSE;
	}
	public function delete($tbl_name,$where){
		$sql = "DELETE FROM {$tbl_name} WHERE ".key($where)."=";
		if(is_numeric(reset($where)))
			$sql.=reset($where);
		else
			$sql.="'".reset($where)."'";
		if($this->mysqli->query($sql))
		{
			if($this->mysql->effected_rows()>0)
				return $this->mysql->effected_rows();
		}
		return FALSE;
	}
	function __destruct(){
		try {
			$this->mysqli->close();
			$this->mysqli=NULL;	
			$this->tbl_name=NULL;
		} catch (Exception $e) {
			
		}
		
	}
}
//$db = new Database();
//$d=$db->get('sheet');
//print_r($d);
?>