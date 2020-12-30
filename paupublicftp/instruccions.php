<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/usersystem/auth.php";
auth();
echo  '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="default.css">
  <title>Planificador d'apats</title>
</head>
<body>
  <h1>Planificador d'apats</h1>
  <p id="demo">Benvingut/da, <?php echo htmlspecialchars(ucfirst($_SESSION["username"])) ?>. </p> <a href="./usersystem/logout.php">Tancar sessió</a><br>

  <p>Aquesta aplicació et permet planificar els apats d'una setmana, i generar la llista de la compra amb els ingredients neccessaris. <br>
  El pla consta d'una serie d'apats cada dia. Cada apat pot contenir un o mes plats. La llista es genera calculant quins ingredients fan falta a partir de les receptes d'aquests plats. </p>

   <h3>Afegeix a la base de dades:</h3>
   <div>
    <a href="./ingredients_add.php">Ingredients</a>
  </div>
  <div>
    <a href="./menjars_add.php">Plats</a>
  </div>
   <p> La aplicació sincronitza la informació de llistes, ingredients, plats i receptes en una base de dades permanent.<br> Aqui trobaràs les opcions per afegir elements a la base de dades.

  </p>  
  <h3>Edita les receptes de cada plat:</h3>
  <div>
    <a href="./recepta/recepta.php">Editar receptes</a>
  </div>
  <p> El editor de receptes et permet escollir un plat i editar la seva recepta. Per afegir ingredients a la recepta, escriu el nom de l'ingredient a l'ultima fila. Els ingredients que tingin un nom que coincideix amb el que tu has escrit apareixeran a sota. Per autocompletar el nom de l'ingredient, pots seleccionar una de les propostes mitjançant les fletxes del teclat i la tecla ENTER o el ratoli. Finalment, per afegir l'ingredient a la recepta, prem la tecla ENTER o prem el boto "Afegir". <br> Si no selecciones una d'aquestes opcions, o el nom que has escrit no coincideix exactament amb un ingredient existent a la base de dades, no podràs afegir l'ingredient a la recepta. <br><br>Consell: Si necessites un ingredient que no existia a la base de dades i no l'has afegit previament, pots afegir-lo directament des de la pagina actual utilitzant la secció "Afegir ingredient rapidament" que trobaràs a la part superior.</p>
  <h3>Planifica't la setmana:</h3>
  <div>
    <a href="./horari.php">Planificació setmanal</a>
  </div>
  <p>
  Una vegada tots els plats que necessites siguin a la base de dades, pots fer-te un pla setmanal assignant plats a cada apat. Recorda definir les receptes, un plat sense recepta no es comptabilitzarà a la llista!<br>
  En la disposició actual hi han 3 apats per dia, i pots assignar tants plats com t'hi capiguin a cada apat. <br>
  Per veure els plats disponibles, selecciona la seva categoria al desplegable de la banda esquerra. Tots els plats d'aquella categoria se't mostraran. Per assignar un plat, arrosega'l del desplegable fins al lloc on vulguis. Per eliminar un plat, arrosega'l a la paperera que trobaràs a la part inferior-dreta. <br>
  Finalment, genera la llista de la compra prement el boto a la part superior-esquerra.
  </p>
  <h3>Genera la llista d'ingredients necessaris:</h3>
  <div>
    <a href="./visor/visorllista.php">La teva llista</a>
  </div>

    <br>
    <br>
    Mes informació: <br>
    <p>Sobre les dades: Ara per ara, la informació d'ingredients, plats i receptes es compartida. El pla setmanal es guarda localment al teu dispositiu, només tu hi pots accedir, no es guarda al servidor. La llista de la compra es propia de cada usuari, només tu hi pots accedir desde qualsevol dispositiu, es guarda al servidor. El servidor no guarda cap tipus d'informació personal mes enllà del nom d'usuari, ni tan sols la contrasenya.</p>
  </div>
</body>

</html>