<?php
include_once '../connect.php';


function getFormula($recipe_id){
	$con = connect_mysql();
	if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; }
	if($stmt = $con->prepare("SELECT ingredient_id, quantitat FROM receptes WHERE menjar_id = ? AND recepta_id = ? ")){
		$stmt->bind_param("ii", $req->m_id, $req->r_id);	
	};
	$stmt->execute();
	$result = $stmt->get_result();
	$outp = $result->fetch_all(MYSQLI_NUM);
	return $ingredients;
}

function addToTotal($ingredients, $times){

}
?>