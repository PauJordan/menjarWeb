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
	<title> Afegir menjar </title>
</head>
<body>

	<?php
		include 'connect.php';
		$con = connect_mysql();
		$name = $con->real_escape_string($_POST["nom"]);
		if(empty($name)){
			echo "Posa el nom siusplau.";
			echo '<br><a href="/menjars_add.php">Torna-ho a provar...</a>';
			exit;
		}

		$sql = "INSERT INTO menjars (nom, categoria)
		VALUES ('".$name."', '".$con->real_escape_string($_POST["categoria"])."')";

		if ($con->query($sql) === TRUE) {
		  echo "Menjar afegit correctament.<br> ";
		  echo '<a href="/menjars_add.php">Afegeix-ne un nou...</a>';
		} 

		else {
			switch ($con->errno) {
				case 1062:
					echo "Error: Aquest plat ja existeix.";
					break;
				
				default:
					echo "Error: ".$con->errno." ". $con->error;
					break;
			}
		  echo '<br><a href="/menjars_add.php">Torna-ho a provar...</a>';
		}

		$con->close();
	?>
</body>
<footer>
<a href="/index.php">Index</a>
</footer>
</html>
