<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
	<script src="horari_functions.js" defer></script>
</head>
<body>
<header>
</header>
<div id="col1" >
	<select id="sel_categoria" name="categoria" onchange=genTable()>
		<option selected disabled>Filtra per categoria:</option>
		<?php
			include 'connect.php';
			create_db_dropdown("menjars_categories", "idcatmenjars");		
		?>
	</select>
	<table id ="filtered_menjars" border='1'>
		<tr>
		<th>Nom</th>
		</tr>
	</table>
</div>
<div id="col2">
	<div class="day_col">
		Dilluns
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Dimarts
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Dimecres
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Dijous
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Divendres
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Dissabte
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	<div class="day_col">
		Diumenge
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
		<div class="meal_interval">
		</div>
	</div>
	
</div>

</body>
<footer>
	<a href="/index.html">Index</a>
	<div id="trash">
		Paperera
	</div>
	<!-- <table border='1'>
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
	</table> -->

</footer>
</html>