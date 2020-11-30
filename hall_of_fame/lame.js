function insertRow(item, index){
			document.getElementById("filtered_menjars").innerHTML += ("<tr><td><p data-menjarid ="+ item["id"]+" class='mobil'>"+item["nom"]+"</p></tr></td>");
		}

function insertRows(){
	document.getElementById("filtered_menjars").innerHTML = "<tr><th>Nom</th></tr>";
	menjars_filtered.forEach(insertRow);
	makeDraggables();	
}
	this.createRows = function(HTMLobj, dataFunction){
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