<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
<div id="col1" >
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
		echo "<td>" . $row['nom'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";

		$con->close();

		?>
	</table>
</div>
<div id="col2">
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
		echo "<td>" . $row['nom'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";

		$con->close();

		?>
	</table>
</div>

</body>
<footer>
<a href="/index.html">Index</a>
</footer>
</html>