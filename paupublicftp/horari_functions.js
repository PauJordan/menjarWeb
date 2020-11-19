var menjars_filtered;
function insertRow(item, index){
			document.getElementById("filtered_menjars").innerHTML += ("<tr><td><p class='mobil'>"+item["nom"]+"</p></tr></td>");
		}
function insertRows(){
	document.getElementById("filtered_menjars").innerHTML = "<tr><th>Nom</th></tr>";
	menjars_filtered.forEach(insertRow);
	makeDraggables();
}
function genTable(){
	var filter = document.getElementById("sel_categoria").value;
	console.log(filter);
	var obj, dbParam, xmlhttp;
	obj = {"categoria":filter};
	dbParam = JSON.stringify(obj);
	console.log(dbParam);
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			//document.getElementById("demo").innerHTML = this.responseText;
			menjars_filtered = JSON.parse(this.responseText);
			insertRows();
		}
		
	};
    		xmlhttp.open("GET", "menjars_query.php?cat=" + dbParam, true);
    		xmlhttp.send();
		}
function makeDraggables(){
	var draggables = document.getElementsByClassName("mobil");
	const containers = document.querySelectorAll(".meal_interval");
	for(i = 0; i < draggables.length; i++){
		draggables[i].draggable = "true";
		draggables[i].ondragstart = function(){this.classList.add("dragging")};
		draggables[i].ondragend = function(){
			this.classList.remove("dragging");
			insertRows();
		};
	};
	for(i = 0; i < containers.length; i++){
		containers[i].ondragover = function(){
			this.appendChild(document.querySelector(".dragging"));
		};
	}
};
const trash = document.querySelector("#trash");
trash.ondragover = function(){
		this.appendChild(document.querySelector(".dragging"));
	};
trash.ondragend = function(){
	this.innerHTML = "Paperera";
}
makeDraggables();