<?php

// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}

include_once './connect.php';
include_once "./list_functions.php";
$con = connect_mysql();
if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; };

$json = file_get_contents('php://input');
$object_in = json_decode($json, true);

$recipes_ids = $object_in["recipes"];

foreach ($recipes_ids as $recipe_id => $qty) {
    echo $recipe_id.": ".$qty."   ";
    $ingredients = getFormula($recipe_id);
    addToTotal($ingredients, $qty);
}


echo json_encode($recipes_ids);


?>