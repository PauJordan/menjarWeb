<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
	<script type="text/javascript" src="horari_functions.js" ></script>
	<script type="text/javascript" src="horari_ini.js"></script>
</head>
<body>
<header>
</header>
<div id="col1" >
	<select id="sel_categoria" name="categoria" onchange="database.createRows_opt(this);">
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

	<script>
		window.addEventListener("DOMContentLoaded", function() {
        	//createDivs(document.getElementById("col2"),7,3,"day_col","meal_interval");
    	}, false);</script>
</div>

</body>
<footer>
	<a href="/index.html">Index</a>
	<div id="trash">
		Paperera
	</div>
</footer>
</html>