


class ListViewer {
	constructor(list){
		this.tableGenInfo = { //Aqui es troba la informació neccessaria per generar la taula d'ingredients de la formula.
      "formula": list,
      "editClass": "autocomplete",
      "fields": [ 
    {name: null, key: null, editable:false, autocomplete:false, htmlobj:this.checkBox},
    {name:"Nom",    key:"name",   editable:false,  autocomplete:false},
    {name:"Quantitat",  key:"qty",    editable:false,  autocomplete:false, align: "right"},
    {name:" ",   key:"unit",   editable:false, autocomplete:false},
    {name:"Cost",  key:"cost",    editable:false,  autocomplete:false, align: "right"}
    ]};
	}

	checkBox = (parent, item) => {
		let checkBox = document.createElement("input");
		checkBox.type = "checkbox";
		parent.appendChild(checkBox);
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

    console.log(genInfo.formula);
    for (let item of genInfo.formula){ //per cada item en la formula
      var row = document.createElement("tr"); //Creem una fila
      for (let i = 0; i < genInfo.fields.length; i++){ // i per cada camp,
        let col = genInfo.fields[i];
        let td = document.createElement("td"); //Creem una cel·la. (col)
        if(col.align){
        	td.align = col.align;
        }
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
    /*
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
    */
  }
}