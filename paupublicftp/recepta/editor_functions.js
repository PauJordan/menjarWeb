class RecipeEditor { 
  //Aquesta classe representa una instància d'editor de receptes. 
  //Accepta un objecte de classe Recipe, un directori de menjars, un  directori d'ingredients i un objecte on anclar-se.
  //Creat per en Pau Oliveras el 7/12/2020.
  constructor(recipeIn, mealIn, ingredientsObj, recipeOutFunction){
    this.recipe = recipeIn;
    this.saveFunction = recipeOutFunction;
    this.meal = mealIn;
    this.ingredients = ingredientsObj;
    this.root = document.createElement("div");
    this.formula = {}; //Aqui es on es guarda la relació de ingredient_id <-> nom, quantitat, unitat, preu... FORMULA.
    for (let pair of this.recipe.ingredients){ //rebem array de parelles de valors (id, quantitat)de la recepta.
      let ingredient = ingredients.getById(pair[0]);
      let qty = pair[1];
      this.formula[ingredient.id] = {"name": ingredient.name, "qty": qty, "unit": ingredient.unit};
    };
    this.tableGenInfo = { //Aqui es troba la informació neccessaria per generar la taula d'ingredients de la formula.
      "formula": this.formula,
      "editClass": "autocomplete",
      "fields": [ 
    {name: null, key: null, editable:false, autocomplete:false, htmlobj:this.remBut},
    {name:"Nom",    key:"name",   editable:true,  autocomplete:true},
    {name:"Quantitat",  key:"qty",    editable:true,  autocomplete:false},
    {name:"Unitat",   key:"unit",   editable:false, autocomplete:false}
    ]};
    return this;
  };
  remBut = (parent, item) => {
    //Afegeix boto que eliminaria l'item corresponent de la formula .
    let rb = document.createElement("input");
    rb.value = "-";
    rb.type = "button";
    rb.addEventListener("click", ()=>{
      this.removeFromFormula(item.name);    
    });
    parent.appendChild(rb);
  }
  addToFormula = (item_name)=>{
    //Afegeix a la formula l'item especificat del directori trobat a partir del seu nom.
    //console.log("add "+ item_name);
    let ingredient = ingredients.getByName(item_name);
    if(ingredient){
      this.formula[ingredient.id] = {"name": ingredient.name, "qty": 0, "unit": ingredient.unit};
      this.render();

    };
  }
  removeFromFormula = (item_name)=>{
    //Treu la formula l'item especificat del directori trobat a partir del seu nom.
    //console.log("remove "+ item_name);
    let ingredient = ingredients.getByName(item_name);
    if(ingredient){
      delete this.formula[ingredient.id];
      this.render();

    };
  }
  formulaUpdate = function(item_id, key, value){
    //Actualitza en la formula l'item amb id = item_id amb el nou valor value. 
    //console.log("update " + key + " from formula item " + item_id + " to " + value);
    this.formula[item_id][key] = value;
  }
  genControls = function(parent){
    //Genera panell de controls BUIT!!!! TODO!
    let controls = document.createElement("div");
    controls.classList.add("controls");
    parent.appendChild(controls);
  }
  genTable = function(parent, genInfo, autocomplete_array){
    //Genera la taula d'ingredients. Necessita el pare, la informació per generar-la i el array amb noms per l'autocompletar.
    let maindiv = document.createElement("div");
    maindiv.id = "formulalist";
    let table = document.createElement("table");
    maindiv.appendChild(table);
    let tableHead = document.createElement("tr");
    parent.appendChild(maindiv);

    for (let col of genInfo.fields){ //crea ths per cada camp
      let th = document.createElement("th");
      th.innerHTML = col.name;
      tableHead.appendChild(th);
    }
    table.appendChild(tableHead);

    for (let item_id of Object.keys(genInfo.formula)){ //per cada item en la formula
      let item = genInfo.formula[item_id];
      var row = document.createElement("tr"); //Creem una fila
      for (let i = 0; i < genInfo.fields.length; i++){ // i per cada camp,
        let col = genInfo.fields[i];
        let td = document.createElement("td"); //Creem una cel·la. (col)
        if(col.editable){
          let inp = document.createElement("input");
          inp.addEventListener("input", ()=>this.formulaUpdate(item_id, col.key, inp.value)); //Si l'usuari edita, actualitza formula.
          inp.value = item[col.key];
          inp.contentEditable = true;
          if(col.autocomplete){ 
            td.classList.add(genInfo.editClass);
            autocomplete(inp, autocomplete_array); //Autocompleta l input amb l'array
          }
          else{
            inp.addEventListener("keyup", event => {
              if(event.key !== "Enter") return; // Use `.key` instead.
              this.saveRecipe(); // Things you want to do.
              event.preventDefault(); // No need to `return false;`.
              });
          }
          td.appendChild(inp);
        } else if(col.htmlobj){ //Realitzar una operació amb la cel·la i l'item.
          col.htmlobj(td, item);
        } else{ //recupera el text normal del camp corresponent del item amb la clau especificada.
          td.innerHTML = item[col.key]; 
        }
        row.appendChild(td);
      }
      table.appendChild(row);
    }
    //Darrera fila per afegir ingredients
    //Cel·la amb autocompletar per afegir nou ingredient.
    let newRow = document.createElement("tr");
    let td0 = document.createElement("td");
    newRow.appendChild(td0);
    let td1 = document.createElement("td");
    let inp = document.createElement("input");
    inp.placeholder = "Introdueix ingredient";
    inp.type = "text";
    inp.addEventListener("keyup", event => {
      if(event.key !== "Enter") return; // Use `.key` instead.
        this.addToFormula(inp.value); 
        event.preventDefault(); // No need to `return false;`.
      });
    td1.classList.add(genInfo.editClass);
    autocomplete(inp, autocomplete_array);
    td1.appendChild(inp);
    newRow.appendChild(td1);
    //Boto d'afegir ingredient
    let td2 = document.createElement("td");
    let but = document.createElement("input");
    but.value = "Afegir";
    but.type = "button";
    but.addEventListener("click", ()=>{ 
      //console.log("adding" + inp.value + "to formula");   
      this.addToFormula(inp.value); 
    });
    td2.appendChild(but);
    newRow.appendChild(td2);
    table.appendChild(newRow);
  }
  saveButton = () => {
      //Boto de guardar la formula en una recepta. Neccesita una funció a qui li passara la recepta de sortida.
      let button = document.createElement("input", "saveButton");
      button.value = "Guardar";
      button.type = "submit";
      button.addEventListener("click", ()=>{ 
        this.saveRecipe();});
     
      return button;
  }

  render = function(){
    //Dibuixa coses al html
    this.root.innerHTML = ""; //Esborra tot
    this.genTable(this.root, this.tableGenInfo, this.ingredients.getNames()); //Generem taula
    //this.genControls(this.root); // I controls
  };
  saveRecipe  = function(){
    //Agafa la formula actual, actualitza els ingredients de la recepta, i la torna.
    this.recipe.ingredients = [];
    for (const id of Object.keys(this.formula)) {
      this.recipe.ingredients.push([id, this.formula[id].qty]);
    }
    this.saveFunction(this.recipe);
    return this.recipe;
  }
};

function autocomplete(inp, arr/*, click_func*/) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              let currentElement = this.getElementsByTagName("input")[0]; //Si l'usuari fa servir autocompletar, dispara un event input per actualitzar la formula.
              inp.value = currentElement.value;
              var ev = new Event('input', {
                  bubbles: true,
                  cancelable: true,
              });
              inp.dispatchEvent(ev); //Envia events al input field per actualitzar coses
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
    }
  }
}


/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}