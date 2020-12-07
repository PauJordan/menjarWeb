var apatDict, ingredients;
var db = new mealDB;
var md = new mealDropdown(document.getElementById("menjar_select"));
db.get("menjars",(data_in)=>{
	menjars = new Food(data_in);
	md.updateOptions(menjars.list);
	});

db.get("ingredients",(data_in)=>{
	ingredients = new Food(data_in, Ingredient);
	});

function echoRecipe(){
	let id_edit = 0;
	id_edit = md.getValue();
	let re_id = (menjars.getById(id_edit))["mainRecipeId"];
	db.getRecipe((result)=>{
		let recipeToEdit = new Recipe(result, menjars);
		launchEditor(recipeToEdit);
	}, re_id);
}

function launchEditor(recipeToEdit){
	var re = new RecipeEditor(recipeToEdit, menjars, ingredients, document.getElementById("editor"));
	re.render();
}