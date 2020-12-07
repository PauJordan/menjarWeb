class Meal{
	constructor(db_json){
		this.id = db_json.id;
		this.name = db_json.name;
		this.category = db_json.category;
	};
	get id(){return this._id};
	set id(new_id){if(!this._id) this._id = new_id}; //Prevent modification once created
}
class Ingredient {
	constructor(db_json){
		this.id = db_json.id;
		this.name = db_json.name;
		this.category = db_json.category;
		this.unit = db_json.unit;
		this.price = db_json.price;
	}
}
function Food(foodArray, type = Meal){
		this.list = [];
		foodArray.forEach((item)=>{
			this.list[item["id"]] = new type(item);
		});
		this.getByCategory = function(category_val){
			return this.list.filter((item)=>{return (item.category == category_val)});
		};
		this.getById = function(id_val){
			return this.list[id_val];
		};
}

function mealDB(){
	this.get = function(tableName, dataFunction){
		var obj = {"categoria":"*"};
		var requestInfo = JSON.stringify(obj);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				result = JSON.parse(this.responseText);
				dataFunction(result);
			};
		}
		request.open("GET", "menjars_query.php?tab=" + tableName + "&cat=" + requestInfo, true);
		request.send();
	}
	this.getMeals = function(dataFunction){
		this.get("menjars", dataFunction);
	}
	this.getIngredients = function(dataFunction){
		this.get("ingredients", dataFunction);
	}
	this.getRecipe = function(dataFunction, meal_id, recipe_id = 0){
		var recipeToGet  = {"m_id":meal_id, "r_id":recipe_id};
		var requestInfo = JSON.stringify(recipeToGet);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				result = JSON.parse(this.responseText);
				dataFunction(result);
			};
		}
		request.open("GET", "./recepta_query.php?req=" + requestInfo, true);
		request.send();
	}
}

class Recipe extends Meal {
	constructor(meal_id, food, new_ingredients, author = "", recipe_id = 0){
		super(food.getById(meal_id));
		this.recipe_id = 0;
		this.ingredients = new_ingredients;
		this.author = "";
	}
}

