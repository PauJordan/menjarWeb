<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
include '../connect.php';
$req = json_decode($_GET["req"], false);
$con = connect_mysql();
if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; }

if($stmt = $con->prepare("SELECT id, name, version, menjar_id, author_id, creation_date FROM receptes WHERE id = ? ")){
	$stmt->bind_param("i", $req->r_id);	
};
$stmt->execute();
$result = $stmt->get_result();
$recepta = $result->fetch_assoc();

if($stmt = $con->prepare("SELECT ingredient_id, quantitat FROM formules WHERE recepta_id = ?")){
	$stmt->bind_param("i", $req->r_id);	
};
$stmt->execute();
$result = $stmt->get_result();
$recepta["ingredients"] = $result->fetch_all(MYSQLI_NUM);

echo json_encode($recepta);

?>