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
	if(re_id){ //if recipe has a main recipe_id; 
		db.pullRecipe((result)=>{
			let recipeToEdit = new Recipe(result, menjars);
			launchEditor(recipeToEdit);
		}, re_id);
	} else {
			let emptyResult = {};
			emptyResult["menjar_id"] = id_edit;
			emptyResult["name"] = "Normal";
			emptyResult["version"] = 0;
			emptyResult["ingredients"] = [];
			let recipeToEdit = new Recipe(emptyResult, menjars);
			launchEditor(recipeToEdit);
	}
	
}

var re; //DEBUG!!!! declarem el editor globalment per poder accedir a les funcions. Instancia'l i renderitza'l.
var sb;
var message;
function sendRecipe(recipeOut){
	message.innerHTML = "	Enviant...";
	db.push(recipeOut, result => message.innerHTML = result);
}
function launchEditor(recipeToEdit){
	let parent = document.getElementById("editor");
	let div =document.getElementById("food_select_div");
	if(re){
		parent.removeChild(re.root);
	}
	if(sb){
		div.removeChild(sb);
		div.removeChild(message);
	}
	re = new RecipeEditor(recipeToEdit, menjars, ingredients, sendRecipe);
	parent.appendChild(re.root);
	re.render();
	
	message = document.createElement("span");
	sb = re.saveButton();
	div.appendChild(sb);
	div.appendChild(message);
}


