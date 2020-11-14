<?php
	function connect_mysql(){
		$connection= new mysqli("localhost:3306","web","Web02sql","testdb");
		if($connection->connect_error) {
	     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		return $connection;
	}
?>