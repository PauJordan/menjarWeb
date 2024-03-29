<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/usersystem/auth.php";
auth();
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
$list = json_decode($db->getList($user_id), true);

$ing_used_ids = array_keys($list);
$ingredients = $db->getIngredients($ing_used_ids);
$listItems = array();
foreach ($ingredients as $i => $ingredient) {
	$listItems[$i]["id"] = $ingredients[$i]["id"];
	$listItems[$i]["category"] = $ingredients[$i]["categoria"];
	$listItems[$i]["name"] = $ingredients[$i]["nom"];
	$listItems[$i]["unit"] = $ingredients[$i]["unitat"];
	$listItems[$i]["qty"] = $list[$ingredient["id"]];
	$listItems[$i]["price"] = floatval($ingredients[$i]["preu"]);
}

echo json_encode($listItems);
}
?>