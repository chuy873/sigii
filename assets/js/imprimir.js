var back = $('span#back');

$(function() {
	back.hide();
});

var botonImp = $('span#impr');

botonImp.on('click', function(){
	var navbar = document.getElementById("nav");
	var wrap = document.getElementById("wrap");
	wrap.removeChild(navbar);
	var bod = document.getElementsByTagName("body")[0];
	var foot = document.getElementsByTagName("footer")[0];
	bod.removeChild(foot);
	
	var calen = document.getElementById("calendar");
	var divs = calen.getElementsByTagName("div");
	var view = divs[0];
	var scroll = divs[16];
	
	view.style.height = "900px";
	scroll.style.height = "900px";
	scroll.style.overflowY = "hidden";
	botonImp.hide();
	$('form#agregarAct').hide();
	back.show();
		
	/*regresa = document.getElementById("impr");
	regresa.href = "/bienvenido.jsp";
	regresa.innerHTML = "Regresar";*/
});

$('span#back').on('click', function() {
	location.reload();
});