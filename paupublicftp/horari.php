<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/usersystem/auth.php";
auth();
echo  '<?xml version="1.0" encoding="utf-8"?>';
?>
<html>
<head>
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
	<script type="text/javascript" src="classes.js" ></script>
	<script type="text/javascript" src="horari_functions.js" ></script>
	<script type="text/javascript" src="horari_ini.js" defer></script>
</head>
<body>
<div id="topbar">	<a href="./visor/visorllista.php">La meva llista</a>
	<a href="/index.php">Inici</a> </div>
<div id="col1">
	<p>Arrosega els plats:</p>
	<select id="sel_categoria" name="categoria" onchange="createRows_opt(this);">
		<option selected disabled>Filtra per categoria:</option>
		<?php
			include 'connect.php';
			create_db_dropdown("menjars_categories", "idcatmenjars");		
		?>
	</select>
	<table id ="filtered_menjars" border='1'>
		
	</table>
</div>
<div id="col2">	
</div>
<div id="trash"> <span> Paperera </span> </div>
</body>
<footer>
	<a href="/index.php">Index</a>
</footer>
</html>