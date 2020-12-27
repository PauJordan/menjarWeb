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
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../default.css">
  <link rel="stylesheet" href="./editor.css">
  <title>Editar recepta</title>
  <script src="../classes.js"></script>
  <script src="./recepta_functions.js"></script>
  <script src="./editor_functions.js"></script>
  <script src="./recepta_ini.js" defer></script>
</head>
  <body>
    <div class = "div_receptes">
    <form id="ing_form" action="../ingredients.php" method="post">
        Afegeix ingredient rapidament: <input type="text" name="nom">
        <!-- Categoria: <input type="text" name="categoria"><br> -->
        <label for="categoria">Categoria:</label>
        <select id="ing_categoria" name="categoria">
          <?php
            include_once '../connect.php';
            create_db_dropdown("ingredients_categories", "categoria", "categoria");   
          ?>
        </select>
        Unitat:
        <select id="ing_unitats" name="unitat">
          <?php
            include_once '../connect.php';
            create_db_dropdown("unitats", "name", "name");    
          ?>
        </select>
        
        Preu: <input type="text" name="preu">
        <input type="submit">
    </form>
  </div>
  <div class="div_receptes" id="food_select_div">
      Editar recepta: 
      <select id="sel_categoria" onchange=md.updateOptions(menjars.getByCategory(this.value));>
        <option selected disabled>Filtra per categoria</option>
        <?php
          include_once '../connect.php';
          create_db_dropdown("menjars_categories", "idcatmenjars");   
        ?>
      </select>
      <select id="menjar_select">
          <option selected disabled value=null>Selecciona apat</option>
      </select>
      <input type="button" value="Editar" onclick="echoRecipe()">
    </div>
    <div id="div_editor">
      <div id="editor" class="autocomplete"> </div>
    </div>
</body>
<footer>
  <a href="/index.php">Index</a>
</footer>
</html>