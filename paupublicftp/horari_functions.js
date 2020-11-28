var menjars_filtered;

function insertRow(item, index){
			document.getElementById("filtered_menjars").innerHTML += ("<tr><td><p data-menjarid ="+ item["id"]+" class='mobil'>"+item["nom"]+"</p></tr></td>");
		}

function insertRows(){
	document.getElementById("filtered_menjars").innerHTML = "<tr><th>Nom</th></tr>";
	menjars_filtered.forEach(insertRow);
	makeDraggables();
	createFoodDict(menjars_filtered, apatDict);
}

function menjarsDB(HTMLobj, dataFunction){
	var filter = HTMLobj.value;
	var obj, dbParam, xmlhttp;
	obj = {"categoria":filter};
	dbParam = JSON.stringify(obj);
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			menjars_filtered = JSON.parse(this.responseText);
			dataFunction();
		};
	};
	xmlhttp.open("GET", "menjars_query.php?cat=" + dbParam, true);
	xmlhttp.send();
}
var apatDict = {};
function createFoodDict(apatArray, dict){
	apatArray.forEach(function (item){
		dict[item["id"]] = item["nom"];
	})
	return dict;
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
			}
			insertRows();
		};
	};
	for(i = 0; i < containers.length; i++){
		containers[i].ondragenter = function(){
			var dragedFood = document.querySelector(".dragging");
			this.appendChild(dragedFood);
			//current_plan.addMeal(dragedFood.dataset.menjarid, this.dataset.x, this.dataset.y);
		};
		/*containers[i].ondragleave = function(){
			var dragedFood = document.querySelector(".dragging");
			current_plan.removeMeal(dragedFood.dataset.menjarid, this.dataset.x, this.dataset.y);
		};*/
	};
	const trash = document.querySelector("#trash");
	trash.ondragenter = function(){
			this.appendChild(document.querySelector(".dragging"));
		};
	trash.ondragend = function(){
		this.innerHTML = "Paperera";
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


function createDivs(parent, nX, nY, classNameX, classNameY){
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
			newDivX.appendChild(newDivY);
		};
		parent.appendChild(newDivX);
	};
}
