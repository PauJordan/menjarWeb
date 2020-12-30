<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/usersystem/auth.php";
auth();
}

include_once 'connect.php';
$con = connect_mysql();

$sql = "INSERT INTO ingredients (nom, categoria, unitat, preu)
VALUES ('".$con->real_escape_string($_POST["nom"])."', '".$con->real_escape_string($_POST["categoria"])."', '".$con->real_escape_string($_POST["unitat"])."', '".$con->real_escape_string(str_replace(",",".",$_POST["preu"]))."')";

if ($con->query($sql) === TRUE) {
  echo "Ingredient afegit correctament.";
} 

else {
  echo "Dades incorrectes. " ;
}

$con->close();

?>

