<?php
/*
 * Control registrar usuario
* Permite insertar los acabados, amenidades, caracteristicas y atributos con los parametros
* que tienen en comun ( nombre, tipo)
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pรกgina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta pแgina.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
//Conexion a DB
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
if(isset($_POST["accion"])){
$accion = $_POST["accion"];		//La accion a ejecutar (registrar, editar, eliminar)
} else if(isset($_GET["accion"])){
	$accion = $_GET["accion"];
}		
if($accion == "registrar"){
	$nombre = $_POST["nombre"];
	$apellidos = $_POST["apellidos"];
	$email = $_POST["email"];
	$telefono = $_POST["telefono"];
	$tipo = $_POST["tipo"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$insert =  sprintf("INSERT INTO  usuarios (nombre, apellidos, email, telefono, tipo, username, password)
			VALUES ('%s','%s','%s','%s','%s','%s','%s');", mysql_real_escape_string($nombre),
			mysql_real_escape_string($apellidos), mysql_real_escape_string($email), mysql_real_escape_string($telefono),
			mysql_real_escape_string($tipo), mysql_real_escape_string($username), mysql_real_escape_string($password));
	$result = mysql_query( $insert );
	if (!$result) {
		die('No se pudo realizar la consulta:' . mysql_error());
		header("Location: ../bienvenido.php");
	} else {	//Redirigir a la pagina correspondiente
			header("Location: ../administrarUsuarios.php");
	}
 } 
 if($accion == "editar"){ 
 	$idusuario = $_POST["idusuario"];
 	$nombre = $_POST["nombre"];
 	$apellidos = $_POST["apellidos"];
 	$email = $_POST["email"];
 	$telefono = $_POST["telefono"];
 	$tipo = $_POST["tipo"];
 	$username = $_POST["username"];
 	$password = $_POST["password"]; 	
 	$update =  sprintf("UPDATE usuarios SET nombre='%s', apellidos='%s', email='%s', telefono='%s', tipo='%s', username='%s', password='%s' 
 			WHERE idusuarios='".$idusuario."'", mysql_real_escape_string($nombre),
 			mysql_real_escape_string($apellidos), mysql_real_escape_string($email), mysql_real_escape_string($telefono),
 			mysql_real_escape_string($tipo), mysql_real_escape_string($username), mysql_real_escape_string($password));
 	$result = mysql_query( $update );
 	if (!$result) {
 		die('No se pudo realizar la consulta:' . mysql_error());
 		header("Location: ../bienvenido.php");
 	} else {	//Redirigir a la pagina correspondiente
 		header("Location: ../administrarUsuarios.php");
 	}
 }
 else if($accion == "delete"){		
		$idusuario = $_GET["id"];		
		$delete =  sprintf("DELETE FROM usuarios WHERE idusuarios = '%s'", mysql_real_escape_string($idusuario));
		$result = mysql_query( $delete );
		if (!$result) {
			die('No se pudo realizar la consulta:' . mysql_error());
			header("Location: ../bienvenido.php");
		} else {	//Redirigir a la pagina correspondiente
			header("Location: ../administrarUsuarios.php");
		}
}
}
?>