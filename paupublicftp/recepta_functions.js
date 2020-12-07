function mealDropdown(parentObj){
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

function echoRecipe(){
	var id = 0;
	id = md.getValue;
	db.getRecipe((result)=>{console.log(new Recipe(result, menjars))}, (menjars.getById(id))["mainRecipeId"]);
}