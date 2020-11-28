<?xml version="1.0" encoding="utf-8"?>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="default.css">
  <title>Editar recepta</title>
  <script src="recepta_functions.js" defer></script>
</head>
<body>
  <div class="div_receptes">
      Edita: 
      <select id="sel_categoria" onchange=genTable(insertOptions)>
        <option selected disabled>Filtra per categoria</option>
        <?php
          include 'connect.php';
          create_db_dropdown("menjars_categories", "idcatmenjars");   
        ?>
      </select>
      <select id="menjar_select">
          <option selected disabled>Selecciona apat</option>
      </select>
      <input type="submit" value="Editar">
    </div>
    <div class="div_receptes">

    </div>
</body>
<footer>
  <a href="/index.html">Index</a>
</footer>
</html>