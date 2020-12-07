class Meal{
	constructor(db_json){
		this.id = db_json.id;
		this.name = db_json.name;
		this.category = db_json.category;
		this.mainRecipeId = db_json.mainRecipeId;
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
	this.getRecipe = function(dataFunction, recipe_id){
		var recipeToGet  = {"r_id":recipe_id};
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


class Recipe {
	constructor(db_json, foodObj){
		this.id = db_json.id;
		this.meal = foodObj.getById(db_json.menjar_id);
		this.version = db_json.version;
		this.name = db_json.name;
		this.author_id = db_json.author_id;
		this.creation_date = db_json.creation_date;
		this.ingredients = db_json.ingredients;
	}
}

class RecipeEditor {
	constructor(recipeIn, menjarsObj, ingredientsObj, parentObj){
		this.recipe = recipeIn;
		this.meals = menjarsObj;
		this.ingredients = ingredientsObj;
		this.root = parentObj;
	}

	render = function(){
		let table = document.createElement("table");
		let tableHead = document.createElement("tr");
		tableHead.innerHTML = "<th>Ingredient</th> <th>Quantitat</th> <th>Unitat</th>";
		table.appendChild(tableHead);

		for(let pair of this.recipe.ingredients){
			let ingredient = this.ingredients.getById(pair[0]);
			let ingredient_qty = parseFloat(pair[1]);

			var row = document.createElement("tr");

			let items = [ingredient.name, ingredient_qty, ingredient.unit /*,"Editar"*/];
			for(let item of items){
				let td = document.createElement("td");
				td.innerHTML = item;
				td.contentEditable = true;
				row.appendChild(td);
			}
			table.appendChild(row);
		}
		this.root.appendChild(table);
	}
}


