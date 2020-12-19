function mealDropdown(parentObj){ 
	//Genera dropdown amb els menjars disponibles.
	this.parent = parentObj;
	this.updateOptions = function(mealArray){
			this.parent.innerHTML = "<option selected disabled>Selecciona apat</option>"; //Clear list
			mealArray.forEach((item)=>{
			var opt = document.createElement("option");
			opt.value = item.id;
			opt.innerHTML = item.name;
			this.parent.appendChild(opt);

		});
	};
	this.getValue = function(){
		return this.parent.value;
	}
}

function echoRecipe(){ //DEBUG!!!! will get removed
	var id = 0;
	id = md.getValue;
	db.pullRecipe((result)=>{console.log(new Recipe(result, menjars))}, (menjars.getById(id))["mainRecipeId"]);
}