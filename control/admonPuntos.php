<?php
/*
 * Control para la el registro de puntos de afluencia
 * Se utiliza la forma para subida de archivos imagen.
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		|| ($usuariologueado->getTipo()=="captura"))) {
	header("Location: ../bienvenido.php");
}
$accion=$_POST["accion"];
if($accion=="editar" || $accion == "insertar"){
$nombrePunto=$_POST["nombrePunto"];
$tipo=$_POST["tipoPunto"];
}
//Conexion a DB
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
//Redirigir a error si el campo esta vacio
if(isset($nombrePunto) && $nombrePunto==""){
	$_SESSION['error'] = "captura";
	$_SESSION['errormsg'] = "El nombre del atributo está vacío";
	$_SESSION['pageFrom']="administrarPuntos";
	header("Location: ../error.php");
} else {
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {  //Si inserta o edita un punto de afluencia con imagen      
      //Obtener el path del logo a guardar 
      $logo="img\puntos\\". $_FILES["file"]["name"];
      if($accion=="insertar"){
      	$insert =  sprintf("INSERT INTO  puntosafluencia (nombre, tipo, logo)
      			VALUES ('%s', '%s', '%s');", mysql_real_escape_string($nombrePunto), mysql_real_escape_string($tipo),
      			mysql_real_escape_string($logo));
      	$result = mysql_query( $insert );
      	//Guardar la imagen nueva
      	move_uploaded_file($_FILES["file"]["tmp_name"],
      			"..\img\puntos\\" . $_FILES["file"]["name"]);
      	header("Location: ../administrarPuntos.php");
      } else if($accion=="editar"){
      	$id=$_POST["idpuntosAfluencia"];
      	//Remover la imagen vieja
      	//Path de la imagen vieja
      	$pathAntiguo = sprintf("SELECT logo FROM puntosafluencia WHERE idpuntosAfluencia = '%s'",mysql_real_escape_string($id));
      	$result = mysql_query( $pathAntiguo );
      	$data = mysql_fetch_row($result);
      	//Borrar imagen
      	unlink('..\\'.$data[0]);
      	//Query de edicion
      	$edit =  sprintf("UPDATE puntosafluencia SET nombre = '%s', tipo = '%s', logo = '%s' WHERE idpuntosAfluencia = '%s'",
      			mysql_real_escape_string($nombrePunto), mysql_real_escape_string($tipo),
      			mysql_real_escape_string($logo),mysql_real_escape_string($id));
      	$result = mysql_query( $edit );        	      	      	
      	//Guardar la imagen nueva
      	move_uploaded_file($_FILES["file"]["tmp_name"],
      			"..\img\puntos\\" . $_FILES["file"]["name"]);
    	//Redirigir a administracion
      	header("Location: ../administrarPuntos.php");
      }     
    }
  }
else
  {  //Si inserta o edita un punto de afluencia sin imagen
   if($accion=="insertar"){
  	$insert =  sprintf("INSERT INTO  puntosafluencia (nombre, tipo)
  			VALUES ('%s', '%s');", mysql_real_escape_string($nombrePunto), mysql_real_escape_string($tipo));
  	$result = mysql_query( $insert );
  	header("Location: ../administrarPuntos.php");
  } else if($accion=="editar"){
  	$id=$_POST["idpuntosAfluencia"];  	
  	$edit =  sprintf("UPDATE puntosafluencia SET nombre = '%s', tipo = '%s' WHERE idpuntosAfluencia = '%s'",
  			mysql_real_escape_string($nombrePunto), mysql_real_escape_string($tipo),
  			mysql_real_escape_string($id));
  	$result = mysql_query( $edit );
  	header("Location: ../administrarPuntos.php");
  } else  if($accion=="eliminar"){
  	$id=$_POST["idpuntosAfluencia"];
  	//Remover la imagen
  	//Path de la imagen
  	$path = sprintf("SELECT logo FROM puntosafluencia WHERE idpuntosAfluencia = '%s'",mysql_real_escape_string($id));
  	$result = mysql_query( $path );
  	$data = mysql_fetch_row($result);
  	//Borrar imagen
  	unlink('..\\'.$data[0]);
  	$eliminar =  sprintf("DELETE FROM puntosafluencia WHERE idpuntosAfluencia = '%s'", mysql_real_escape_string($id));
  	$result = mysql_query( $eliminar );
  	header("Location: ../administrarPuntos.php");
}
  }
  }  
?>