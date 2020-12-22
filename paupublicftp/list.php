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

$db = new Database();

if($_SERVER["REQUEST_METHOD"] == "POST"){

$json = file_get_contents('php://input');
$object_in = json_decode($json, true);

$recipes_ids = $object_in["recipes"];

$list = new IngredientList();
foreach ($recipes_ids as $recipe_id => $times) {
    //echo $recipe_id.": ".$times."   ";
    $ingredients = $db->getFormula($recipe_id);
    $list->addToTotal($ingredients, $times);
}

$user_id = $_SESSION["id"];
$encoded_list = json_encode($list->getList());
$db->saveList($user_id, $encoded_list);

echo 0;

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

$user_id = $_SESSION["id"];
$listData["list"] = json_decode($db->getList($user_id), true);

$ing_used_ids = array_keys($listData["list"]);
$listData["ingredients"] = $db->getIngredients($ing_used_ids);

echo json_encode($listData);
}
?>