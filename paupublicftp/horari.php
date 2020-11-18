<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
	<script>
		function insertRows(item, index){
			document.getElementById("filtered_menjars").innerHTML += ("<tr><td>"+item["nom"]+"</tr></td>");
		}
		function genTable(){
			var filter = document.getElementById("sel_categoria").value;
			console.log(filter);
			var obj, dbParam, xmlhttp, menjars_filtered;
			obj = {"categoria":filter};
			dbParam = JSON.stringify(obj);
			console.log(dbParam);
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
  				if (this.readyState == 4 && this.status == 200) {
    				//document.getElementById("demo").innerHTML = this.responseText;
    				menjars_filtered = JSON.parse(this.responseText);
    				document.getElementById("filtered_menjars").innerHTML = "<tr><th>Nom</th></tr>";
    				menjars_filtered.forEach(insertRows);
    			}
    			
    		};
    		xmlhttp.open("GET", "menjars_query.php?cat=" + dbParam, true);
    		xmlhttp.send();
		}
	</script>
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