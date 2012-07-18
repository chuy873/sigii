/*
 * SIGII 
 * Scripts de validaciones
 * Se verifican los campos de registro del sistema
 * Se validan datos numericos, vacios, confirmacion de contraseñas,...
 */
//Validacion inicio de sesion
$(function() {
  
  //pagina de login
  $('#usuario').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "No puede estar vacio"
  });

  $('#pwd').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "No puede estar vacio"
  });
});

 //Validacion registro y edicion de usuario
$().ready(function() { 
    // validate signup form on keyup and submit 
	$("#registroUsuario").validate({
		rules:{
		nombre:"required",
		apellidos:"required",		
		email:{required:true,email: true},	
		tipo:"required",
		username:{required:true, remote: { url: "control/verificarUsuario.php", async: false }},
		password:{required:true,minlength: 6},
		passwordC:{required:true,equalTo: "#password"},
		
		},

		messages:{
		nombre:"Ingresa el nombre",
		apellidos:"Ingresa los apellidos",
		email:{
		required:"Ingresa el correo electrónico",
		email:"Ingresa un correo válido (usuario@ejemplo.com)"},
		tipo:"",
		username: { required:"Ingresa el nombre de usuario", remote: "El nombre de usuario ya existe"},
		password:{
		required:"Ingresa la contraseña",
		minlength:"La contraseña debe tener 6 caracteres como mínimo"},
		passwordC:{
		required:"Ingresa la confirmación de contraseña",
		equalTo:"La contraseña y la confirmación de contraseña deben ser iguales"},
		
		},

		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass)
		{
		$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass)
		{
		$(element).parents('.control-group').removeClass('error');
		$(element).parents('.control-group').addClass('success');
		}
		});
		});
//Validacion registro de proyecto
$().ready(function() { 
    // validate signup form on keyup and submit 
	$("#registroUsuario").validate({
		rules:{
		nombre:"required",
		apellidos:"required",		
		email:{required:true,email: true},	
		tipo:"required",
		username:"required",
		password:{required:true,minlength: 6},
		passwordC:{required:true,equalTo: "#password"},
		
		},

		messages:{
		nombre:"Ingresa el nombre",
		apellidos:"Ingresa los apellidos",
		email:{
		required:"Ingresa el correo electrónico",
		email:"Ingresa un correo válido (usuario@ejemplo.com)"},
		tipo:"",
		username:"Ingresa el nombre de usuario",
		password:{
		required:"Ingresa la contraseña",
		minlength:"La contraseña debe tener 6 caracteres como mínimo"},
		passwordC:{
		required:"Ingresa la confirmación de contraseña",
		equalTo:"La contraseña y la confirmación de contraseña deben ser iguales"},
		
		},

		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass)
		{
		$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass)
		{
		$(element).parents('.control-group').removeClass('error');
		$(element).parents('.control-group').addClass('success');
		}
		});
		});
/*


$(document).ready(function(){
    $("#registroUsuario").validate();
  });
  //empieza pagina de registrar

  $('#password').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacio"
  });

  $('#passwordC').validate( {
    expression: "if(VAL == $('#password').val() && VAL) return true; else return false;",
    message: "Las contrase\u00F1as deben ser iguales"
    //message: "Las contraseÃ±as deben ser iguales" no funciona en jsp debe usarse el caracter en unicode
  });
  $('#nombre').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacio"
  });  
  $('#nombre').blur(function() {
	  verificarNombre(this.value);
	  });
  $('#nombre').click(function() {
	    document.getElementById("alertNombre").style.display='none';
	  });
  $('#apellidos').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacio"
  });

  $('#tipo').validate( {
    expression: "if (isChecked(SelfID)) return true; else return false;",
    message: "Seleccione un tipo de usuario"
  });

  jQuery("#email").validate({
    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
    message: "Formato de email no v\u00E1lido"
    //message: "Formato de email no vÃ¡lido"
  });

*/
//validacion administrar usuarios
/*
$('.confirm-delete').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal1').modal('show');
});
$('.confirm-edit').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal2').modal('show');
});
$('.confirm-delete').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal3').modal('show');
});
$('.confirm-add').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal4').modal('show');
});
$('.confirm-pos').click(function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    $('#modal1').modal('show');
});

//validacion pagina seleccionarProyAdmin
$('#idproyecto1').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "Selecciona un proyecto"
  });
$('#idproyecto2').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "Selecciona un proyecto"
  });
$('#idproyecto3').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "Selecciona un proyecto"
  });
//termina validacion pagina seleccionarProyAdmin
//validacion pagina editarUsuario
$('#username').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "No puede estar vacio"
  });
//termina editarUsuario
//validacion administrarAmenidads
$('#nombreamenidad').validate( {
    expression: "if(VAL) return true; else return false;",
    message: "No puede estar vacio"
  });
//validacion registro de proyecto
$('#promotor').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacio"
  });
$('#etapa').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No has seleccionado la etapa"
  });
$('#segmento').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No has seleccionado el segmento"
  });

$('#municipio').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacío"
  });

$('#ciudad').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No has seleccionado la zona"
  });
$('#subzonaSelect').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No has seleccionado la subzona"
  });
//Validacion de imagenes distribucion y fachadas en divs generados
$(".inputdistribucion").live("click", function(event){
	 $(".inputdistribucion").change( function()
			    {
		comprueba_extension( $(this).val(),$(this).attr('id'));
			    });
});

$(".inputfachada").live("click", function(event){
	 $(".inputfachada").change( function()
			    {
		comprueba_extension( $(this).val(),$(this).attr('id'));
			    });
});
*/
//validacion pisos y torres
