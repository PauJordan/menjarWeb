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



function handleSubmit(submitEvent){
	const form = submitEvent.target;

	fetch(form.action, {
		method: form.method,
		body: new FormData(form)
	})
	.then(response => response.text())
	.then(ingDisplay.display)
	.then(() => db.get("ingredients",(data_in)=>{
	//Recupera els ingredients del servidor i quan acabis, crea el directori "ingredients".
	ingredients = new Food(data_in, Ingredient);
	re.updateIngredients(ingredients);
	}));
	
	//Prevent Default http sync request
	submitEvent.preventDefault();
}

document.addEventListener("submit", handleSubmit);