<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
<header>
</header>
<div id="col1" >
	<select id="sel_categoria" name="categoria" onchange=>
				<?php
					include 'connect.php';
					create_db_dropdown("ingredients_categories", "categoria", "categoria");		
				?>
	</select>
	<table border='1'>
		<tr>
		<th>Categoria</th>
		<th>Nom</th>
		</tr>
	</table>
		<p id = "demo">Hi</p>
		<script>
			var filter = document.getElementById("sel_categoria").innerHTML;
			var obj, dbParam, xmlhttp;
			obj = {"categoria":"Carn"};
			dbParam = JSON.stringify(obj);
			console.log(dbParam);
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
  				if (this.readyState == 4 && this.status == 200) {
    				document.getElementById("demo").innerHTML = this.responseText;
    			}
    		};
    		xmlhttp.open("GET", "menjars_query.php?cat=" + dbParam, true);
    		xmlhttp.send();
    	</script>	
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