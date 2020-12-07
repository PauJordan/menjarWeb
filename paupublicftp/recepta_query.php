<?php
include 'connect.php';
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

//This section translates DB names into CLIENT JS object structure.
/*
$out_translated = array();
$translation_map = array("id"=>"id","nom"=>"name","categoria"=>"category","unitat"=>"unit","preu"=>"price");
foreach ($outp as $entry) {
	$new_entry = array();
	foreach ($entry as $key => $value) {
		$new_entry[$translation_map[$key]] = $value;
	}
	array_push($out_translated, $new_entry);
}
*/
//Return translated JSON

echo json_encode($recepta)

?>