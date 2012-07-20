<?php
/*
 * Control guardarEarth
 * Permite guardar el archivo kml del proyecto recibido como parametro
 * Almacena el archivo en servidor y el registro en la base de datos.
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pรกgina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		|| ($usuariologueado->getTipo()=="captura"))) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta pแgina.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");
} else {
	include "../clases/Conexion.php";
	$conexion = new Conexion();
	$link = $conexion->dbconn();
$idproyecto=$_POST["idproyecto"];
//google earth
$earth=$_POST["earth"];
$file = '../img/earth/'.$idproyecto.'_earth.kml.';
//Agregar al archivo la informacion de kml de google earth.
$current = $earth;
// Escribir los datos en servidor
file_put_contents($file, $current);
//Registrar en DB
$insertEarth=sprintf("INSERT INTO posicionearth (pathArchivoKML, proyecto_idproyecto)
		VALUES ('%s','%s');", 'img/earth/'.$idproyecto.'_earth.kml',$idproyecto);
$result = mysql_query( $insertEarth);
header("Location: ../".$_SESSION['pageFrom'].".php");
}
?>