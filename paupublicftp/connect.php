<?php
	function connect_mysql(){
		$connection= new mysqli("192.168.3.180:3306","xamp","xamp","testdb");
		if($connection->connect_error) {
	     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		return $connection;
	}

	function create_db_dropdown($table, $val_col, $disp_col = NULL, $filter = ""){
		/*This function querys db to create a dropdown. If no disp is specified, same as value.*/
		if (is_null($disp_col)){ //Check if disp_col is used and select only requiered columns.
			$disp_col = $val_col;
			$columns = $val_col;
		}
		else{
			$columns = $val_col.", ".$disp_col;
		}
		
		$con = connect_mysql();
		if($result = $con->query("SELECT ".$columns." FROM ".$table." ".$filter)){
						$errcode = "";
						while($row = $result->fetch_assoc()){
						
						echo '<option vaule="'.$row[$val_col].'">'.$row[$disp_col].'</option>' ;
						}
					}
					else { $errcode = "Error: (" . $con->errno . ") " . $con->error."<br>";}					
					$con->close();	

	}



class Database {
	public $con;
	private $stmt;
	function connect() {
		$connection= new mysqli("192.168.3.180:3306","xamp","xamp","testdb");
		if($connection->connect_error) {
    		die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		return $connection;
	}
	function __construct(){
		$this->con = $this->connect();
	}
	function __destruct(){
		$this->con->close();
	}
	
	
	function query($stmt){
		$this->stmt = $stmt;
		$this->stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	function getFormula($id){
		
		if($stmt = $this->con->prepare(
			"SELECT ingredient_id, quantitat FROM formules WHERE recepta_id = ?"))
		{
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_NUM);	
		};
	}

	function saveList($user_id, $json){
		if($stmt = $this->con->prepare(
			"INSERT INTO llistes (user_id, llista) VALUES (?, ?) ON DUPLICATE KEY UPDATE llista = VALUES (llista) "))
		{
			$stmt->bind_param("is", $user_id, $json);
			$stmt->execute();
		} else {
			echo("Error description: " . $this->con->error);
		}
	}
		
	function getList($user_id){
		if($stmt = $this->con->prepare(
			"SELECT llista FROM llistes WHERE user_id = ?"))
		{
			$stmt->bind_param("i", $user_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_row();
			return $row[0];

		};
	}
		 
	function getIngredients($ingredients_ids){
		$sql = 'SELECT * 
         FROM ingredients
         WHERE id IN (' . implode(',', array_map('intval', $ingredients_ids)) . ')';

         if($stmt = $this->con->prepare($sql)){
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);

		};
	}
}


?>