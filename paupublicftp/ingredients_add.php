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
					include 'connect.php';
					$con = connect_mysql();
					if($result = $con->query("SELECT idcategories FROM ingredients_categories")){
						$errcode = "";
						while($row = $result->fetch_assoc()){
						$value = $row['idcategories'];
						echo '<option vaule="'.$value.'">'.$value.'</option>' ;
						}
					}
					else { $errcode = "Error: (" . $con->errno . ") " . $con->error."<br>";}					
					$con->close();			
				?>
			</select><br>
			Unitat: <input type="text" name="unitat"><br>
			Preu: <input type="text" name="preu"><br>
			<input type="submit">
		</fieldset>
	</form>
</body>
<footer>
<?php echo $errcode; ?>
<a href="/index.html">Index</a>
</footer>
</html>
