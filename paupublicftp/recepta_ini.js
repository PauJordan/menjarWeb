var apatDict, ingredients;
var db = new mealDB;
var md = new mealDropdown(document.getElementById("menjar_select"));
db.get("menjars",(data_in)=>{
	menjars = new Food(data_in);
	});

db.get("ingredients",(data_in)=>{
	ingredients = new Food(data_in, Ingredient);
	});
