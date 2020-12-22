<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
include '../connect.php';

$con = connect_mysql();
if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; };

$json = file_get_contents('php://input');
$recipe_in = json_decode($json, true);

if(array_key_exists('id', $recipe_in)){
	$id = updateRecipe($con, $recipe_in);
	updateFormula($con, $recipe_in, $id);
} else if (array_key_exists('meal', $recipe_in)){
	$id = insertRecipe($con, $recipe_in);
	$recipe_in["id"] = $id;
	updateFormula($con, $recipe_in, $id);
} else {
	echo "petició invalida.";
	exit;
}

function insertRecipe($con, $recipe){
	
	$meal_id = $recipe["meal"]["_id"];
	$version = 0;
	$name = $recipe["name"];
	$author_id = $_SESSION["id"];

	if($stmt = $con->prepare("INSERT INTO receptes (menjar_id, version, name, author_id) VALUES (?, ?, ?, ?)")){
		$stmt->bind_param("iisi", $meal_id, $version, $name, $author_id);	
	};
	$stmt->execute();
	$result = $con->query("SELECT LAST_INSERT_ID()")->fetch_assoc();
	$new_id = $result["LAST_INSERT_ID()"];

	if($stmt = $con->prepare("UPDATE menjars SET recepta_principal_id = ? WHERE id = ? AND recepta_principal_id IS NULL")){
		$stmt->bind_param("ii", $new_id, $meal_id);	
	};
	$stmt->execute();
	
	return $new_id;
}

function updateRecipe($con, $recipe){

	$id = $recipe["id"];
	$author_id = $_SESSION["id"];

	if($stmt = $con->prepare("UPDATE receptes SET author_id = ?, version = version + 1 WHERE id = ?")){
		$stmt->bind_param("ii", $author_id, $id);
		$stmt->execute();
		return $id;
	};
	
}

function updateFormula($con, $recipe, $id){
	if($stmt = $con->prepare("DELETE FROM formules WHERE recepta_id = ?")){
			$stmt->bind_param("i", $id);	
			$stmt->execute();
		};
	$recepta_id = intval($id);
	foreach ($recipe["ingredients"] as $ingredient) {
		$ingredient_id = intval($ingredient[0]);
		$qty = floatval($ingredient[1]);
		if($stmt = $con->prepare("INSERT INTO formules (recepta_id, ingredient_id, quantitat) VALUES (?, ?, ?) ")){
			$stmt->bind_param("iid", $recepta_id, $ingredient_id, $qty);
			$stmt->execute();
		};
	};
	echo "Desat correctament.";
}
/*

if($recipe["id"])
$id = $recipe["id"];
$ingredients = $recipe["ingredients"];
$author_id = $_SESSION["id"];
$author_name = $_SESSION["username"];

$valid_request = true;
if($valid_request == false){
	exit;
}



if($stmt = $con->prepare("SELECT id, name, version, menjar_id, author_id, creation_date FROM receptes WHERE id = ? ")){
	$stmt->bind_param("i", $recipe["id"]);	
};
$stmt->execute();
$result = $stmt->get_result();
$recepta = $result->fetch_assoc();



*/







/*
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
*/



?>