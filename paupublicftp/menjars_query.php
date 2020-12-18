<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
//Aquest document rep les peticions de descarrega de plats.
include 'connect.php';
$obj = json_decode($_GET["cat"], false);
$con = connect_mysql();
if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; }
if($obj->categoria != "*"){
	if($stmt = $con->prepare("SELECT * FROM menjars WHERE categoria = ? ")){
		$stmt->bind_param("s", $obj->categoria);	
	}
}
else if($_GET["tab"] == "menjars" | $_GET["tab"] == "ingredients"){
	$stmt = $con->prepare("SELECT * FROM ".$_GET["tab"]);
}
else{
	$stmt = $con->prepare("SELECT * FROM menjars");
};

$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC);
//This section translates DB names into CLIENT JS object structure.
$out_translated = array();
$translation_map = array("id"=>"id","nom"=>"name","categoria"=>"category","unitat"=>"unit","preu"=>"price","recepta_principal_id" => "mainRecipeId");
foreach ($outp as $entry) {
	$new_entry = array();
	foreach ($entry as $key => $value) {
		$new_entry[$translation_map[$key]] = $value;
	}
	array_push($out_translated, $new_entry);
}
//Return translated JSON
echo json_encode($out_translated);


?>