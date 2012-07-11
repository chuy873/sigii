function rechaza(id){
	document.getElementById("rechaza-"+id).value = "true";
	document.getElementById("form-"+id).submit();
}

function acepta (id){
	document.getElementById("acepta-"+id).value = "true";
	document.getElementById("form-"+id).submit();
}