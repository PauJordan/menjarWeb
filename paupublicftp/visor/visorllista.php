<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
?>
 <?xml version="1.0" encoding="utf-8"?>
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
  <p id="demo">La teva llista, <?php echo htmlspecialchars($_SESSION["username"]) ?> </p>
  <div>
      <div id="visor" class="autocomplete"> </div>
  </div>
</body>
<footer>
  <a href="../horari.php">Planificació setmanal</a>
  <a href="/index.php">Index</a><br> 
</footer>
</html>

<!--
<div>
    <textarea id="textbox"></textarea>


  </div>
  -->