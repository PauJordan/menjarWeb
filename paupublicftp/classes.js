class Ingredient {
//Representa un item a adquirir com a materia prima necessaria per la creació d'una unitat de un menjar, un plat.
	constructor(db_json){
		this.id = db_json.id;
		this.name = db_json.name;
		this.category = db_json.category;
		this.unit = db_json.unit;
		this.price = db_json.price;
		this.kind = "Ingredient";
	}
}

class Meal{ 
//ELs objectes d'aqusta classe representen un plat, un item de menjar que una dieta pot incloure en un apat, un interval concret que pot contenir diversos plats. Conte un id de recepta. 
	constructor(db_json){
		this.id = db_json.id;
		this.name = db_json.name;
		this.category = db_json.category;
		this.mainRecipeId = db_json.mainRecipeId;
		this.kind = "Plat";
	};
	get id(){return this._id};
	set id(new_id){if(!this._id) this._id = new_id}; //Prevent modification once created
}

class Recipe {
//Representa una recepta, les instruccions i el llistat d'ingredients per la preparació d'un plat. Es editable, temporal, te autoria i data de creació.
//Relaciona els ids dels directoris de plats i ingredients amb una quantitat. Un plat pot tenir multiples metodes de preparació i receptes.
	constructor(db_json, foodObj){
		this.id = db_json.id;
		this.meal = foodObj.getById(db_json.menjar_id);
		this.version = db_json.version;
		this.name = db_json.name;
		this.author_id = db_json.author_id;
		this.creation_date = db_json.creation_date;
		this.ingredients = db_json.ingredients;
		this.kind = "Recepta";
	}
}



function Food(foodArray, type = Meal){
//Crea un directori de menjar, ja siguin ingredients o plats. 
//Proporciona diversos mètodes per recuperar sub-conjunts d'aquests en funció de la seva categoria, nom o id.
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
		this.getNames = function(){
			return (this.list.map(ingredient => ingredient.name)).filter((item)=>{return item});	
		};
		this.getByName = function(name) {
			return (this.list.filter((item)=>{return (item.name == name)}))[0];			
		};
}

function mealDB(){
//Crea una interficie amb la base de dades remota.
//Proporciona diversos mètodes per sol·licitar relacions de ingredients, plats, i receptes.
	const dbMap = { //Mapejem objectes amb la localització dels recursos
		"Recepta": {
			"resource": "../recepta/recepta_push.php",
			"headers": {
				'Content-Type':'application/json'
			}
		},
		"Plat": {
			"resource": "../menjars_send.php",
			"headers": {
				'Content-Type':'application/json'
			}
		},
		"Ingredient": {
			"resource": "../ingredients_send.php",
			"headers": {
				'Content-Type':'application/json'
			}
		},
		"Llista":{
			"resource": "../list.php",
			"headers": {
				'Content-Type':'application/json'
			}
		}
	}
	this.get = function(tableName, dataFunction){
		//Sol·licita tot de la taula tableName i quan rebis la resposta, crida la funció dataFunction.
		var obj = {"categoria":"*"};
		var requestInfo = JSON.stringify(obj);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				result = JSON.parse(this.responseText);
				dataFunction(result);
			};
		}
		request.open("GET", "../menjars_query.php?tab=" + tableName + "&cat=" + requestInfo, true);
		request.send();
	}
	this.push = function(item, dataFunction){
		var json = JSON.stringify(item); //Conver item to JSON
		var request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let result = this.responseText;
				dataFunction(result);
			};
		}
		let itemMap = dbMap[item.kind];
		request.open("POST", itemMap.resource, true);
		for(header of Object.keys(itemMap.headers)){
			request.setRequestHeader(header, itemMap.headers[header]);
		}
		request.send(json);
	}
	this.getMeals = function(dataFunction){
		this.get("menjars", dataFunction);
	}
	this.getIngredients = function(dataFunction){
		this.get("ingredients", dataFunction);
	}
	this.pullRecipe = function(dataFunction, recipe_id){
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






