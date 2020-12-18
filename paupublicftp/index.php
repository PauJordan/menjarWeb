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
  <link rel="stylesheet" href="default.css">
  <title>Food Planner</title>
</head>
<body>
  <h1>Food Planner</h1>
  <p id="demo">Benvingut/da, <?php echo htmlspecialchars($_SESSION["username"]) ?> </p>
  <div>
    <a href="./ingredients_list.php">Veure ingredients</a>
  </div>
  <div>
    <a href="./ingredients_add.php">Afegir ingredient</a>
  </div>
  <div>
    <a href="./menjars.php">Buscar menjars</a>
  </div>
  <div>
    <a href="./menjars_add.php">Afegir menjars</a>
  </div>
  <div>
    <a href="./horari.php">Planificació setmanal</a>
  </div>
  <div>
    <a href="./recepta.php">Mostrar recepta</a>
  </div>
  <div>
    <a href="./usersystem/register.php">Registrar-se</a>
  </div>
  <div>
    <a href="./usersystem/login.php">Iniciar sessió</a>
  </div>
  <div>
    <a href="./usersystem/logout.php">Tancar sessió</a>
  </div>
  <div>
    <!-- <a href="./downloads/safe.mov" download="safe.mov">safe</a> -->
  </div>
</body>
<footer>
  <br>
  By Pau
</footer>
</html>