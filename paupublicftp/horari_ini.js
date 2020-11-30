var current_plan = new plan("test", 7, 4);
var galeta = getCookie("plan_save");
if(galeta){
	current_plan.days = galeta;
}
var database = new mealDB();
database.getMeals(dbLoaded);
