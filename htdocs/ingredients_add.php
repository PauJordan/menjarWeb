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
<title>Ingredients add</title>
</head>
<body>
	<header>
		<a href="/index.php">Inici</a>
	</header>
	<form action="ingredients_send.php" method="post">
		<fieldset>
			Nom: <input type="text" name="nom">
			<!-- Categoria: <input type="text" name="categoria"><br> -->
			<label for="categoria">Categoria:</label>
			<select id="categoria" name="categoria">
				<?php
					include_once 'connect.php';
					create_db_dropdown("ingredients_categories", "categoria", "categoria");		
				?>
			</select>
			Unitat:
			<select id="categoria" name="unitat">
				<?php
					include_once 'connect.php';
					create_db_dropdown("unitats", "name", "name");		
				?>
			</select>
			
			Preu: <input type="text" name="preu">
			<input type="submit">
		</fieldset>
	</form>
<?php
$con = connect_mysql();
$result = $con->query("SELECT * FROM ingredients ORDER BY nom");
echo "<table border='1'>
<tr>
<th>Nom</th>
<th>Categoria</th>
<th>Unitat</th>
<th>Preu</th>
</tr>";

while($row = $result->fetch_assoc())
{
echo "<tr>";
echo "<td>" . $row['nom'] . "</td>";
echo "<td>" . $row['categoria'] . "</td>";
echo "<td>" . $row['unitat'] . "</td>";
echo "<td>" . $row['preu'] . "</td>";
echo "</tr>";
}
echo "</table>";

$con->close();

?>
</body>
<footer>
</footer>
</html>
