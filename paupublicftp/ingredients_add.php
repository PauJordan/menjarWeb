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
	<form action="ingredients_send.php" method="post">
		<fieldset>
			Nom: <input type="text" name="nom"><br>
			<!-- Categoria: <input type="text" name="categoria"><br> -->
			<label for="categoria">Categoria:</label>
			<select id="categoria" name="categoria">
				<?php
					include_once 'connect.php';
					create_db_dropdown("ingredients_categories", "categoria", "categoria");		
				?>
			</select><br>
			Unitat: <input type="text" name="unitat"><br>
			Preu: <input type="text" name="preu"><br>
			<input type="submit">
		</fieldset>
	</form>
</body>
<footer>
<a href="/index.php">Index</a>
</footer>
</html>
