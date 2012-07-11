/*
 * SIGII 
 * Scripts de validaciones
 * Se verifican los campos de registro del sistema
 * Se validan datos numericos, vacios, confirmacion de contraseñas,...
 */

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
  //termina pagina de login

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

});
//validacion administrar usuarios

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
$('#unidadesTotales').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacío"
  });
$('#unidadesVendidas').validate( {
    expression: "if (VAL) return true; else return false;",
    message: "No puede estar vacío"
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
//validacion pisos y torres
