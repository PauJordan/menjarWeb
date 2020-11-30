function mealDropdown(parentObj){
	this.parent = parentObj;
	this.updateOptions = function(mealArray){
			this.parent.innerHTML = "<option selected disabled>Selecciona apat</option>"; //Clear list
			mealArray.forEach((item)=>{
			var opt = document.createElement("option");
			opt.value = item.id;
			opt.innerHTML = item.name;
			this.parent.appendChild(opt);

		})
	}
}