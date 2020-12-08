var apatDict, ingredients; //directori de apats i d'ingredients
var db = new mealDB; //Instanciem base de dades remota.
var md = new mealDropdown(document.getElementById("menjar_select")); //Instanciem dropdown.
db.get("menjars",(data_in)=>{
	//Recupera els menjars del servidor i quan acabis, bolca les dades al directori "menjars" i actualitza les opcions disponibles. 
	menjars = new Food(data_in);
	md.updateOptions(menjars.list);
	});

db.get("ingredients",(data_in)=>{
	//Recupera els ingredients del servidor i quan acabis, crea el directori "ingredients".
	ingredients = new Food(data_in, Ingredient);
	});

function echoRecipe(){ //DEBUG PROVISIONAL!!!!! 
	//Llegeix apat seleccionat i demana al servidor la recepta corresponent del servidor. 
	//Quan rebis la resposta, crea la recepta a editar i executa l'editor de receptes amb aquesta.
	let id_edit = 0;
	id_edit = md.getValue();
	let re_id = (menjars.getById(id_edit))["mainRecipeId"];
	db.getRecipe((result)=>{
		let recipeToEdit = new Recipe(result, menjars);
		launchEditor(recipeToEdit);
	}, re_id);
}

var re; //DEBUG!!!! declarem el editor globalment per poder accedir a les funcions. Instancia'l i renderitza'l.
function launchEditor(recipeToEdit){
	re = new RecipeEditor(recipeToEdit, menjars, ingredients, document.getElementById("editor"));
	re.render();
}