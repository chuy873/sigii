<?php
/*
 * Control admonAtributos
 * Permite editar, eliminar, agregar los acabados, amenidades, caracteristicas y atributos con los parametros
 * que tienen en comun (id, nombre, tipo)
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
//Conexion a DB
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();

$accion = $_GET["accion"];			//La accion a ejecutar (agregar, eliminar, borrar)
$tipo=$_GET["tipo"];				//El tipo de atributo (amenidad, acabado, caracteristicas...)
//Verificar que acción ejecutar
if($accion=="edit"){
$nombre=$_GET["nombre"];			//El nuevo nombre a actualizar
//Redirigir a error si el campo esta vacio
	if($nombre==""){
		$_SESSION['error'] = "captura";
		$_SESSION['errormsg'] = "El nombre del atributo está vacío";
		if($tipo=="acabado"){
			$_SESSION['pageFrom']="administrarAcabados";
		}else if($tipo=="amenidad"){
			$_SESSION['pageFrom']="administrarAmenidades";
		}else if($tipo=="atributos"){
			$_SESSION['pageFrom']="administrarAtributos";
		}else if($tipo=="caracteristicas"){
			$_SESSION['pageFrom']="administrarCaracteristicas";
		}
		header("Location: ../error.php");
	} else {

$id=$_GET["id"];					//El id del objeto
//Seguridad SQLi
$insert =  sprintf("UPDATE %s SET nombre = '%s' WHERE id%s = '%s'",
		mysql_real_escape_string($tipo), mysql_real_escape_string($nombre),
		mysql_real_escape_string($tipo), mysql_real_escape_string($id));
$result = mysql_query( $insert );
	}
//Accion agregar
} else if($accion=="insert"){
	$nombre=$_GET["nombre"];
	//Redirigir a error si el campo esta vacio
	if($nombre==""){
		$_SESSION['error'] = "captura";
		$_SESSION['errormsg'] = "El nombre del atributo está vacío";
		if($tipo=="acabado"){
			$_SESSION['pageFrom']="administrarAcabados";
		}else if($tipo=="amenidad"){
			$_SESSION['pageFrom']="administrarAmenidades";
		}else if($tipo=="atributos"){
			$_SESSION['pageFrom']="administrarAtributos";
		}else if($tipo=="caracteristicas"){
			$_SESSION['pageFrom']="administrarCaracteristicas";
		}
		header("Location: ../error.php");
	} else {
	//Seguridad SQLi
	$insert =  sprintf("INSERT INTO  %s (`nombre`)
			VALUES ('%s');",mysql_real_escape_string($tipo), mysql_real_escape_string($nombre));
	$result = mysql_query( $insert );
	}
	//Accion borrar
} else if($accion=="delete"){
	$id=$_GET["id"];
	//Seguridad SQLi
	$delete =  sprintf("DELETE FROM %s WHERE id%s = '%s'",
			mysql_real_escape_string($tipo), mysql_real_escape_string($tipo),
			mysql_real_escape_string($id));
	$result = mysql_query( $delete );	
}
//Redirigir en caso de error
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	header("Location: ../bienvenido.php");
} else {	//Redirigir a la pagina correspondiente
	if($tipo=="acabado"){
		header("Location: ../administrarAcabados.php");
	}else if($tipo=="amenidad"){
		header("Location: ../administrarAmenidades.php");
	}else if($tipo=="atributos"){
		header("Location: ../administrarAtributos.php");
	}else if($tipo=="caracteristicas"){
		header("Location: ../administrarCaracteristicas.php");
	}
}

?>