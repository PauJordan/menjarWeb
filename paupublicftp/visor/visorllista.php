<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/usersystem/auth.php";
auth();
echo  '<?xml version="1.0" encoding="utf-8"?>';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../default.css">
  <link rel="stylesheet" href="./visor.css">
  <title>La meva llista</title>
  <script type="text/javascript" src="../classes.js" ></script>
  <script type="text/javascript" src="visor_functions.js" defer></script>
  <script type="text/javascript" src="visor_ini.js" defer></script>
</head>
<body>
  <h2>Llista</h2>
  <header>
    <span>Canvia-la a</span>
    <a href="../horari.php">Planificació setmanal</a>
    <span>.  Torna a</span>
    <a href="/index.php">Inici</a><br>   </header>
  
  <p id="demo">La teva llista, <?php echo htmlspecialchars($_SESSION["username"]) ?> </p>
  <div>
      <div id="visor" class="autocomplete"> </div>
  </div>
</body>
<footer>
  
</footer>
</html>

<!--
<div>
    <textarea id="textbox"></textarea>


  </div>
  -->