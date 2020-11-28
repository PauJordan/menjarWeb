<?php
include 'connect.php';
$obj = json_decode($_GET["cat"], false);
$con = connect_mysql();
if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; }

if($stmt = $con->prepare("SELECT * FROM menjars WHERE categoria = ? ")){
	$stmt->bind_param("s", $obj->categoria);
	$stmt->execute();
	$result = $stmt->get_result();
	$outp = $result->fetch_all(MYSQLI_ASSOC);
	echo json_encode($outp);
}








?>