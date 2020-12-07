var apatDict, ingredients;
var db = new mealDB;
var md = new mealDropdown(document.getElementById("menjar_select"));
db.get("menjars",(data_in)=>{
	menjars = new Food(data_in);
	});

db.get("ingredients",(data_in)=>{
	ingredients = new Food(data_in, Ingredient);
	});

function echoRecipe(){
	var id_edit = 0;
	id_edit = md.getValue();
	db.getRecipe((result)=>{console.log(new Recipe(id_edit, menjars, result, "Pau"))}, id_edit, 0);
}