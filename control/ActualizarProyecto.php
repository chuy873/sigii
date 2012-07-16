<?php
/*
 * Control Actualizar Proyecto
* Permite actualizar los datos de los proyectos.
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		|| ($usuariologueado->getTipo()=="captura"))) {
	header("Location: ../bienvenido.php");
}
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto="";
//datos basicos
$idproyecto=$_POST["proyecto"];
$precio=$_POST["precio"];
$meses=$_POST["meses"];
$vendidasXMes=$_POST["vendidaXMes"];
$vendidasTotales=$_POST["vendidasTotales"];
date_default_timezone_set('America/Monterrey');
$getVendidas = "SELECT unidadesVendidas, fechaRevision FROM proyecto WHERE idproyecto='".$idproyecto."'";
$result=mysql_query($getVendidas);
$data=mysql_fetch_array($result);

$almacenarHistorico="INSERT INTO datohistorico (idproyecto, vendidasTotales, fechaDatos  ) 
VALUES ('".$idproyecto."','".$data["unidadesVendidas"]."','".$data["fechaRevision"]."')";
mysql_query($almacenarHistorico);
$actualizarProyecto=sprintf("UPDATE proyecto SET unidadesVendidas = '%s', fechaRevision='%s' WHERE idproyecto=' ".$idproyecto."'",
 mysql_real_escape_string($vendidasTotales), date("y-m-d"));
mysql_query($actualizarProyecto);
header("Location: ../".$_SESSION["pageFrom"].".php");
?>