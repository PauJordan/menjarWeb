<html>
<head>
	<link rel="stylesheet" href="default.css">
	<title>Afegir menjars</title>
</head>
<body>
	<form action="menjars_send.php" method="post">
		<fieldset>
			Nom: <input type="text" name="nom"><br>
			<!-- Categoria: <input type="text" name="categoria"><br> -->
			<label for="categoria">Categoria:</label>
			<select id="categoria" name="categoria">
				<?php
					include 'connect.php';
					create_db_dropdown("menjars_categories", "idcatmenjars");		
				?>
			</select><br>
			<input type="submit">
		</fieldset>
	</form>
</body>
<footer>
	<?php echo $errcode; ?>
	<a href="/index.html">Index</a>
</footer>
</html>
