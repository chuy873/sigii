<?php
/*
 * Control EliminarProyecto
* Se permite eliminar el proyecto horizontal y vertical y registrar los cambios en la DB
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
$idproyecto=$_POST["idproyecto"];
//Obtener el tipo de proyecto
$getTipo = "SELECT tipo FROM proyecto WHERE idproyecto = '".$idproyecto."'";
$result=mysql_query($getTipo);
$data=mysql_fetch_array($result);
$tipo=$data["tipo"];
//Eliminar imagenes de la carpeta
$getImagenes="SELECT path FROM imagenes WHERE proyecto_idproyecto = '".$idproyecto."'";
$result=mysql_query($getImagenes);
while($data=mysql_fetch_array($result)){
	echo "entro";
	unlink("..\\".$data["path"]);
}

//Eliminar de DB

$eliminarProyecto="DELETE FROM proyecto WHERE idproyecto='".$idproyecto."'";
$result=mysql_query($eliminarProyecto);
header("Location: ../".$_SESSION["pageFrom"].".php");
}
?>