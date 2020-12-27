var listItemsDir;


fetch('../list.php',{ method: "GET"})
  .then(response => response.json())
  .then(data => {
  	listItemsDir = new Food(data, ListItem);
  	listItemsDir.sortItems("category");
  	launchViewer();
  });

function launchViewer(){
	let listItems = listItemsDir.list;
	var viewer = new ListViewer(listItems);
	let root = document.getElementById("visor");
	viewer.genTable(root, viewer.tableGenInfo);
}


