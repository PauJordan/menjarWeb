
class ShopingList {
	constructor(ingredientDirectory){
		this.items = [];
		this.ingDir = ingredientDirectory;
	}
	addFromJSON = function(json){
		const items = JSON.parse(json);
		for(ing_id of Object.keys(items)){
			const ingredient = this.ingDir.getById(ing_id);
			const qty = items[ing_id];
			let listItem = new ListItem(ingredient, qty, false);
			this.items.push(listItem);
		}
	}
}


class PlatCounter{
	constructor(db){
		this.recipes = {};
		this.kind = "Llista";
		this.db = db;
		this.messageP = document.createElement("span");
	};
	add = function(plat_id){
		const recipe_id = selectRecipe(plat_id);
		if(recipe_id in this.recipes){		
			this.recipes[recipe_id]++;
		} else if(recipe_id){
			this.recipes[recipe_id] = 1;
		} else {
			console.log("Atenció, el plat "+apatDict.getById(plat_id).name+" no te recepta.");
		}
	};
	empty = function(){
		this.recipes = {};
	};
	print = function(){
		for(recipe_id of object.keys(this.recipes)){
			console.log("recipe : " + this.recipes[recipe]);
		};
	};
	count = (plats) => {
		this.message("	Enviant...");
		this.empty();
		for (var i = 0; i < plats.length; i++) {
			for (var j = 0; j < plats[i].length; j++) {
				if(plats[i][j]){
					for(var k = 0; k < plats[i][j].length; k++){
						this.add(plats[i][j][k]);

					};
				};
			};
		};
		this.db.push(this, (response) => {
			if(response == 0) {
				this.message("	Desat correctament.");
			} else {
				this.message("	Error del servidor... Paaaaaaau que has feeet?");
				console.log(response);
			}
		});
	}
	saveButton = (getPlats) => {
      //Boto de guardar la formula en una recepta. Neccesita una funció a qui li passara la recepta de sortida.
      let button = document.createElement("input", "saveButton");
      button.value = "Generar i desar llista";
      button.type = "submit";
      button.addEventListener("click", ()=> this.count(getPlats));
      return button;
  	}
  	message = (displayText)=> {
  		this.messageP.innerHTML = displayText;
  	}
}



var apatDict;

var result;

function createRows_opt(HTMLobj){
		var filter = HTMLobj.value;
		document.getElementById("filtered_menjars").innerHTML = "";
		var selection = apatDict.getByCategory(filter);
		selection.forEach((item)=>{
			document.getElementById("filtered_menjars").innerHTML += ("<tr><td><p data-menjarid ="+ item["id"]+" class='mobil'>"+item["name"]+"</p></tr></td>");
		});
		makeDraggables();
	}


function dbLoaded(result){
	apatDict = new Food(result);
	createDivs(document.getElementById("col2"),7,3,"day_col","meal_interval");
	makeDraggables();
}

function selectRecipe(plat_id){ //TODO PATCH !!!!
	return apatDict.getById(plat_id).mainRecipeId;
}

function createFoodArray(apatArray){
	var list = [];
	apatArray.forEach(function (item){
		list.push(new Meal(item["id"], item["nom"], item["categoria"]));
	})
	return list;
}



function makeDraggables(plan){
	var draggables = document.getElementsByClassName("mobil");
	const containers = document.querySelectorAll(".meal_interval");
	for(i = 0; i < draggables.length; i++){
		draggables[i].draggable = "true";
		draggables[i].ondragstart = function(){
			this.classList.add("dragging")
			var container = this.parentElement;
			if(container.classList.contains("meal_interval")){	
				current_plan.removeMeal(this.dataset.menjarid, container.dataset.x, container.dataset.y);
				//console.log("remove " + this.dataset.menjarid +" from " + container.dataset.x +", "+ container.dataset.y);

			}
		};
		draggables[i].ondragend = function(){
			this.classList.remove("dragging");
			var container = this.parentElement;
			if(container.classList.contains("meal_interval")){	
				current_plan.addMeal(this.dataset.menjarid, container.dataset.x, container.dataset.y);
				//console.log("add " + this.dataset.menjarid +" to " + container.dataset.x +", "+ container.dataset.y);
				setCookie("plan_save",JSON.stringify(current_plan.days));
			}
			else if(container.id == "trash"){
				setCookie("plan_save",JSON.stringify(current_plan.days));
				this.remove();
			}
			createRows_opt(document.getElementById("sel_categoria"));
		};
	};
	for(i = 0; i < containers.length; i++){
		containers[i].ondragenter = function(){
			var dragedFood = document.querySelector(".dragging");
			this.appendChild(dragedFood);
			//current_plan.addMeal(dragedFood.dataset.menjarid, this.dataset.x, this.dataset.y);
		};
	};
	const trash = document.getElementById("trash");
	trash.ondragenter = function(){
			this.appendChild(document.querySelector(".dragging"));
		};
}

function plan(new_name, nX, nY){
	this.days = [];
	this.name = new_name;
	for(var x = 0; x < nX; x++) {
		this.days.push([])
		for (var y = 0; y < nY; y++) {
			this.days[x].push([]);
		}; 
	};
	this.addMeal = function(meal_id, x, y){
		this.days[x][y].push(meal_id);
	}
	this.removeMeal = function(meal_id, x, y){ //Check last item of array is really what we are trying to remove befor really rmoving it.
		if(this.days[x][y][this.days[x][y].length - 1] == meal_id){ 
			this.days[x][y].pop();
		}
		
	}
}


function createDivs(parent, nX, nY, classNameX, classNameY, saved_plan = undefined){
	var dies = ["Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte", "Diumenge"];
	var divArray; 
	for (var x = 0; x < nX; x++) {
		var newDivX = document.createElement("div");
		newDivX.classList.add(classNameX);
		newDivX.innerHTML = dies[x];
		for(var y = 0; y < nY; y++){
			var newDivY = document.createElement("div");
			newDivY.dataset.x = x;
			newDivY.dataset.y = y;
			newDivY.classList.add(classNameY);
			var meals_in_here = current_plan.days[x][y];
			meals_in_here.forEach((item)=>{
				var newP = document.createElement("p");
				newP.dataset.menjarid = item;
				newP.classList.add("mobil");
				var newMeal = apatDict.getById(item);
				newP.innerHTML = newMeal.name;
				newDivY.appendChild(newP);
			})
			newDivX.appendChild(newDivY);
		};
		parent.appendChild(newDivX);
	};
}

function setCookie(cname, cvalue) {
	var exdate = new Date();
	let exdays = 365;
   	exdate.setDate(exdate.getDate() + exdays);
  	document.cookie = cname + "=" + cvalue + (!exdays ? "" : "; expires=" + exdate.toUTCString())  + ";path=/";
}
function getCookie(cname){
	var dc = document.cookie;
	var match_result = dc.match(cname + "=([^;]+)"); //Search name= with eveything behind except ;
	if(match_result){ //If match exists
		return JSON.parse(match_result[1]); //Parse JSON from match string
	}
	else{
		return undefined;
	}
}
