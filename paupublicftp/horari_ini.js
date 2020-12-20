var current_plan = new plan("test", 7, 4);
var galeta = getCookie("plan_save");
if(galeta){
	current_plan.days = galeta;
}
var db = new mealDB();
db.getMeals(dbLoaded);


var llista = new ShopingList(recipesOut => db.push(recipesOut, response => console.log(response)) );
var genButton = llista.saveButton(current_plan.days);
let c1 = document.getElementById("col1");
c1.insertBefore(genButton, c1.firstChild);

