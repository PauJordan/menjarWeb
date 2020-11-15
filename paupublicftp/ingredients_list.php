<html>
<head>
	<title>Llista ingredients</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
<?php
include 'connect.php';
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
<a href="/index.html">Index</a>
</footer>
</html>