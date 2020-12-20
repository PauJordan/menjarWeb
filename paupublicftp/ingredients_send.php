<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
?>
<html>
<head>
	<link rel="stylesheet" href="default.css">
	<title> Ingredient add </title>
</head>
<body>

	<?php
	include 'connect.php';
	$con = connect_mysql();

	$sql = "INSERT INTO ingredients (nom, categoria, unitat, preu)
	VALUES ('".$con->real_escape_string($_POST["nom"])."', '".$con->real_escape_string($_POST["categoria"])."', '".$con->real_escape_string($_POST["unitat"])."', '".$con->real_escape_string(str_replace(",",".",$_POST["preu"]))."')";

	if ($con->query($sql) === TRUE) {
	  echo "Ingredient afegit correctament.<br> ";
	  echo '<a href="/ingredients_add.php">Afegeix-ne un nou...</a>';
	} 

	else {
	  echo "Error: " . $sql . "<br>" . $con->error. "<br>";
	  echo '<a href="/ingredients_add.php">Torna-ho a provar...</a>';
	}

	$con->close();
	
	?>
</body>
<footer>
<a href="/index.php">Index</a>
</footer>
</html>
