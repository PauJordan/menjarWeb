<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../usersystem/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="default.css">
  <link rel="stylesheet" type="text/css" href="index.css">
  <title>Planificador d'apats</title>
</head>
<body>
  <h1>Planificador d'apats</h1>
  <p id="demo">Benvingut/da, <?php echo htmlspecialchars(ucfirst($_SESSION["username"])) ?>. </p> <a href="./usersystem/logout.php">Tancar sessió</a>
  <br><a href="./instruccions.php">Instruccions</a>
   
   <h3> Afegeix a la base de dades:</h3>
  <div>
    <a href="./ingredients_add.php">Ingredients</a>
  </div>
  <div>
    <a href="./menjars_add.php">Plats</a>
  </div>
  <h3>Edita les receptes de cada plat:</h3></span>
  <div>
    <a href="./recepta/recepta.php">Editar receptes</a>
  </div>
  <h3>Planifica't la setmana:</h3>
  <div>
    <a href="./horari.php">Planificació setmanal</a>
  </div>
  <h3>Genera la llista d'ingredients necessaris:</h3>
  <div>
    <a href="./visor/visorllista.php">La teva llista</a>
  </div>

  <div>
    <!-- <a href="./downloads/safe.mov" download="safe.mov">safe</a> -->
  </div>
</body>
<footer>
  <br>
  By Pau and Laura
</footer>
</html>