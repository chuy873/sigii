
function insertar(tipo){
	var nombre = document.getElementById("nombre"+tipo).value;	
	location.replace("control/admonAtributos.php?accion=insert&nombre="+nombre+"&tipo="+tipo);	
	}
function insertarPunto(tipo){
	var nombre = document.getElementById("nombre"+tipo).value;
	var nombre = document.getElementById("nombre"+tipo).value;
	location.replace("control/admonAtributos.php?accion=insert&nombre="+nombre+"&tipo="+tipo);
	}
//Funciones de administracion de amenidades, acabados,...
//para activar modal y enviar el id en un input hidden.
$(document).on("click", ".openEditAmen", function () {
    var idamenidad = $(this).data('id');
    var nombre = $(this).data('nombre');
    $(".modal-body #idamenidad").val(idamenidad);
    $(".modal-body #editaramenidad").val(nombre);
    $(".modal-body #editaramenidad").focus();
   $('#modalEditar').modal('show');
});

$(document).on("click", ".openEditAtrib", function () {
    var idatributos = $(this).data('id');
    var nombre = $(this).data('nombre');
    $(".modal-body #idatributos").val(idatributos);
    $(".modal-body #editaratributos").val(nombre);
   $('#modalEditar').modal('show');
});

$(document).on("click", ".openEditAcab", function () {
    var idacabado = $(this).data('id');
    var nombre = $(this).data('nombre');
    $(".modal-body #idacabado").val(idacabado);
    $(".modal-body #editaracabado").val(nombre);
   $('#modalEditar').modal('show');
});

$(document).on("click", ".openEditCaract", function () {
    var idcaracteristicas = $(this).data('id');
    var nombre = $(this).data('nombre');
    $(".modal-body #idcaracteristicas").val(idcaracteristicas);
    $(".modal-body #editarcaracteristicas").val(nombre);
   $('#modalEditar').modal('show');
});

$(document).on("click", ".openEditPuntos", function () {
    var idpuntosAfluencia = $(this).data('id');
    dataPuntos(idpuntosAfluencia);
    $(".modal-body #idpuntosAfluencia").val(idpuntosAfluencia);
   $('#modalEditar').modal('show');
});

//Funcion editar
//Se activa al presionar el boton editar en el modal
function editar(tipo){
	var nombre = document.getElementById("editar"+tipo).value;
	var id = document.getElementById("id"+tipo).value;
	//procesa la edicion
	location.replace("control/admonAtributos.php?accion=edit&nombre="+nombre+"&tipo="+tipo+"&id="+id);
	}

$(document).on("click", ".openDeleteAmen", function () {
    var idamenidad = $(this).data('id');
    $(".modal-body #idamenidadD").val(idamenidad);
   $('#modalBorrar').modal('show');
});

$(document).on("click", ".openDeleteAtrib", function () {
    var idatributos = $(this).data('id');
    $(".modal-body #idatributosD").val(idatributos);
   $('#modalBorrar').modal('show');
});

$(document).on("click", ".openDeleteAcab", function () {
    var idacabado = $(this).data('id');
    $(".modal-body #idacabadoD").val(idacabado);
   $('#modalBorrar').modal('show');
});

$(document).on("click", ".openDeleteCaract", function () {
    var idcaracteristicas = $(this).data('id');
    $(".modal-body #idcaracteristicasD").val(idcaracteristicas);
   $('#modalBorrar').modal('show');
});

$(document).on("click", ".openDeletePuntos", function () {
    var idpuntosAfluencia = $(this).data('id');
    $(".modal-body #idpuntosAfluenciaD").val(idpuntosAfluencia);
   $('#modalBorrar').modal('show');
});

$(document).on("click", ".openDeleteProyecto", function () {
    var idproyecto = $(this).data('id');
    $(".modal-body #idproyectoD").val(idproyecto);
   $('#modalBorrar').modal('show');
});
$(document).on("click", ".openDeleteModelo", function () {
    var idmodelo = $(this).data('id');
    $(".modal-body #idmodeloD").val(idmodelo);
   $('#modalBorrar').modal('show');
});
function eliminar(tipo){
	var id = document.getElementById("id"+tipo+"D").value;	
	location.replace("control/admonAtributos.php?accion=delete&tipo="+tipo+"&id="+id);
	}

$(document).on("click", ".openDeleteUser", function () {
    var idusuario = $(this).data('id');
    $(".modal-body #idusuarioD").val(idusuario);
   $('#modalBorrar').modal('show');
});
function eliminarUsuario(){
	var id = document.getElementById("idusuarioD").value;	
	location.replace("control/admonUsuario.php?accion=delete&id="+id);
	}
//Otras funciones con modal
$('.confirm-add').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal4').modal('show');
});
/*
 * Funcion AJAX para obtener las subzonas de una zona seleccionada.(registro)
 */
function desplegarSubzona(zona)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	 
    document.getElementById("subzona").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","control/getZonas.php",true);
xmlhttp.setRequestHeader("Content-Type",
"application/x-www-form-urlencoded; charset=UTF-8");
xmlhttp.send("zona="+escape(zona));
}

/*
 * Funcion AJAX para obtener datos de un punto de afluencia seleccionado.(administracion)
 */
function dataPuntos(id)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	  var s= xmlhttp.responseText ;
	  var myArray = s.split(",");	 
	  var nombre = myArray[0];
	  var tipo = myArray[1];
	  var logo = myArray[2];
    document.getElementById("nombrePunto").value=nombre;
    if(tipo=="Hospitales"){
    document.getElementById("tipoPunto").selectedIndex=0;
    } else  if(tipo=="Centros comerciales"){
    document.getElementById("tipoPunto").selectedIndex=1;
    } else {
    document.getElementById("tipoPunto").selectedIndex=2;
    }
    document.getElementById("logoPunto").src=logo;
    }
  }
xmlhttp.open("POST","control/getPunto.php",true);
xmlhttp.setRequestHeader("Content-Type",
"application/x-www-form-urlencoded; charset=UTF-8");
xmlhttp.send("id="+escape(id));
}

/*
 * Funcion AJAX para generar una nueva forma de registro de puntos de afluencia.(registro)
 */
var contPuntos = 1;
if(document.getElementById("contPuntos2")){
	contPuntos=(document.getElementById("contPuntos2").value - 1);
}
function desplegarOtro() {
	contPuntos ++;	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var select = xmlhttp.responseText;
			var newdiv = document.createElement('div');
			var clase = 'control-group';
			newdiv.setAttribute('class', clase);
			newdiv.innerHTML = "<label class='control-label'>Tipo </label>"
					+ "<div class='controls'>"
					+ select
					+ "<span class='help-inline'></span>"
					+ "</div><div class='control-group'>"
					+ "<label class='control-label'>Punto "+contPuntos +"</label>"
					+ "<div class='controls' id='punto"+ contPuntos+ "'>"
					+ "	</div></div> <label class="
					+ "'control-label'>Distancia</label><div class='controls'><input name='distanciaAfluencia"
					+ contPuntos
					+ "'class='input-small'"
					+ " type='text'> kil&oacute;metros <span class='help-inline'></span></div><hr/>	";
			document.getElementById("puntoStart").appendChild(newdiv);
			document.getElementById("contPuntos").value = contPuntos;
			if(document.getElementById("contPuntos2")){				
			contPuntos+=1;
			document.getElementById("contPuntos2").value = contPuntos;
			}
		}
	}
	xmlhttp.open("POST", "control/getPunto.php", true);
	xmlhttp.setRequestHeader("Content-Type",
			"application/x-www-form-urlencoded; charset=UTF-8");
	xmlhttp.send("accion=tipos&numero=" + contPuntos);
}

/*
 * Funcion AJAX para obtener los puntos de un tipo seleccionado.(registro)
 */
function desplegarPuntos(tipo, numero)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	 
    document.getElementById("punto"+numero).innerHTML=xmlhttp.responseText;
	document.getElementById("contPuntos").value = contPuntos;
    }
  }
xmlhttp.open("POST","control/getPunto.php",true);
xmlhttp.setRequestHeader("Content-Type",
"application/x-www-form-urlencoded; charset=UTF-8");
xmlhttp.send("tipo="+escape(tipo)+"&accion=registro&numero="+numero);
}

$(document).on("click", ".openCancel2", function () {
      $('#modalCancel1').modal('show');
});

$(document).on("click", ".quit", function () {
    $('#forma').each (function(){
    	  this.reset();
    });
	$('#modalCancel1').modal('hide'); 
});

/*
 * Funcion AJAX para verificar si el nombre de proyecto/modelo ya existe
 */
function verificarNombre(nombre)
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	
	 if(xmlhttp.responseText=="1"){
		 document.getElementById("nombre").value="";			 
    document.getElementById("alertNombre").style.display='block';
	 }
    }
  }
xmlhttp.open("POST","control/verificaNombre.php",true);
xmlhttp.setRequestHeader("Content-Type",
"application/x-www-form-urlencoded; charset=UTF-8");

if(document.getElementById("modelo")!=null){
xmlhttp.send("nombre="+escape(nombre)+"&modelo="+document.getElementById("modelo").value);
}else{
	if(document.getElementById("id")!=null){		
		xmlhttp.send("nombre="+escape(nombre)+"&proyecto="+document.getElementById("id").value);
	} else {
xmlhttp.send("nombre="+escape(nombre));} 
}
}

//Funcion para enviar la forma de modelo y regresar a la pagina de registro de modelo nuevo
function agregarOtro(){
	document.getElementById("agregar").value="add";
}