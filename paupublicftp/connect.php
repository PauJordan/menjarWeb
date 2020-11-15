<?php
	function connect_mysql(){
		$connection= new mysqli("localhost:3306","web","Web02sql","testdb");
		if($connection->connect_error) {
	     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		return $connection;
	}

	function create_db_dropdown($table, $val_col, $disp_col = " "){
		/*This function querys db to create a dropdown. If no disp is specified, same as value.*/
		if ($disp_col == " "){ //Check if disp_col is used and select only requiered columns.
			$disp_col = $disp_val;
			$columns = $val_col;
		}
		else{
			$columns = $val_col.", ".$disp_col;
		}
		
		$con = connect_mysql();
		if($result = $con->query("SELECT ".$columns." FROM ".$table)){
						$errcode = "";
						while($row = $result->fetch_assoc()){
						
						echo '<option vaule="'.$row[$val_col].'">'.$row[$disp_col].'</option>' ;
						}
					}
					else { $errcode = "Error: (" . $con->errno . ") " . $con->error."<br>";}					
					$con->close();	

	}
?>