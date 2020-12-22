var current_plan = new plan("test", 7, 4);
var galeta = getCookie("plan_save");
if(galeta){
	current_plan.days = galeta;
}
var db = new mealDB();
db.getMeals(dbLoaded);


var counter = new PlatCounter(db);
var genButton = counter.saveButton(current_plan.days);
var bar = document.getElementById("topbar");
var counterDisplay = counter.messageP;
bar.insertBefore(counterDisplay, bar.firstChild);
bar.insertBefore(genButton, bar.firstChild);

