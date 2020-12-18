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
	<title>Llista menjars</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
	<table border='1'>
		<tr>
		<th>Categoria</th>
		<th>Nom</th>
		</tr>
		<?php
		include 'connect.php';
		$con = connect_mysql();
		$result = $con->query("SELECT * FROM menjars ORDER BY categoria, nom");


		while($row = $result->fetch_assoc())
		{
		echo "<tr>";
		echo "<td>" . $row['categoria'] . "</td>";
		echo "<td contenteditable='true'>" . $row['nom'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";

		$con->close();

		?>
</body>
<footer>
<a href="/index.php">Index</a>
</footer>
</html>