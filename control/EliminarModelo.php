<?php
/*
 * Control EliminarModelo
* Se permite eliminar el modelo horizontal y vertical y registrar los cambios en la DB
*/
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
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idmodelo=$_POST["idmodelo"];

//Eliminar imagenes de la carpeta
$getImagenes="SELECT path FROM imagenes WHERE modelo_idmodelo = '".$idmodelo."'";
$result=mysql_query($getImagenes);
while($data=mysql_fetch_array($result)){
	echo "entro";
	unlink("..\\".$data["path"]);
}

//Eliminar de DB

$eliminarModelo="DELETE FROM modelo WHERE idmodelo='".$idmodelo."'";
$result=mysql_query($eliminarModelo);
header("Location: ../administrarModelos.php");
}
?>