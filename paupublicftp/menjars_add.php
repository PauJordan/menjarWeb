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
	<title>Afegir menjars</title>
</head>
<body>
	<header>
		<a href="/index.php">Inici</a>
	</header>
	<form action="menjars_send.php" method="post">
		<fieldset>
			Nom: <input type="text" name="nom">
			<!-- Categoria: <input type="text" name="categoria"><br> -->
			<label for="categoria">Categoria:</label>
			<select id="categoria" name="categoria">
				<?php
					include 'connect.php';
					create_db_dropdown("menjars_categories", "idcatmenjars");		
				?>
			</select>
			<input type="submit">
		</fieldset>
	</form>
	<table border='1'>
		<tr>
		<th>Categoria</th>
		<th>Nom</th>
		</tr>
		<?php
		$con = connect_mysql();
		$result = $con->query("SELECT * FROM menjars ORDER BY categoria, nom");


		while($row = $result->fetch_assoc())
		{
		echo "<tr>";
		echo "<td>" . $row['categoria'] . "</td>";
		echo "<td contenteditable='true'>" . $row['nom'] . "</td>";
		echo "</tr>";
		}
		$con->close();

		?>
	</table>
</body>
<footer>
</footer>
</html>
