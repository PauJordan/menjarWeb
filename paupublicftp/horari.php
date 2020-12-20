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
	<title>Horari</title>
	<link rel="stylesheet" href="default.css">
	<script type="text/javascript" src="classes.js" ></script>
	<script type="text/javascript" src="horari_functions.js" ></script>
	<script type="text/javascript" src="horari_ini.js" defer></script>
</head>
<body>

<div id="col1">
	<select id="sel_categoria" name="categoria" onchange="createRows_opt(this);">
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
</div>

</body>
<footer>
	<a href="/index.php">Index</a>
	<div id="trash">
		Paperera
	</div>
</footer>
</html>