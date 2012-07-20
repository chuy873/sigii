<?php
/*
 * Control Actualizar Proyecto
* Permite actualizar los datos de los proyectos.
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";	
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		|| ($usuariologueado->getTipo()=="captura"))) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto="";
//datos basicos
$idproyecto=$_POST["proyecto"];
$numMod=$_POST["numMod"];
$tipo=$_POST["tipo"];
$i=0;
$precio[][2]="";
while($i <= $numMod){
$precio[$i][0]=$_POST["modelo".$i];	
$precio[$i][1]=$_POST["precio".$i];
$i++;
}
$meses=$_POST["meses"];
$vendidasXMes=$_POST["vendidaXMes"];
$vendidasTotales=$_POST["vendidasTotales"];
//Actualizar a DB
//Zona horaria
date_default_timezone_set('America/Monterrey');
//Obtener el dato previo para guardarlo en el historico
$getVendidas = "SELECT unidadesVendidas, fechaRevision FROM proyecto WHERE idproyecto='".$idproyecto."'";
$result=mysql_query($getVendidas);
$data=mysql_fetch_array($result);
//Actualizar precios de modelos
if($tipo=="horizontal"){
foreach($precio as $value){	
$updatePrecio = sprintf("UPDATE modelofraccionamiento SET precio = '%f' WHERE modelo_idmodelo='%s'",
		mysql_real_escape_string($value[1]),mysql_real_escape_string($value[0]));
mysql_query($updatePrecio);
}
} else if($tipo=="vertical"){
foreach($precio as $value){	
$updatePrecio = sprintf("UPDATE modelodepartamento SET precioPromedio = '%f' WHERE modelo_idmodelo='%s'",
		mysql_real_escape_string($value[1]),mysql_real_escape_string($value[0]));
mysql_query($updatePrecio);
}
}
$almacenarHistorico="INSERT INTO datohistorico (idproyecto, vendidasTotales, fechaDatos  ) 
VALUES ('".$idproyecto."','".$data["unidadesVendidas"]."','".$data["fechaRevision"]."')";
mysql_query($almacenarHistorico);
//Actualizar datos a DB
//Fecha de revision es un mes anterior
//Fecha actual
$dia=date("d");
$mes=date("m");
$anio=date("Y");
if($mes==01){
	$mes=12;
	$anio=$anio-1;
} else {$mes=$mes-1;}
$actualizarProyecto=sprintf("UPDATE proyecto SET unidadesVendidas = '%s', fechaRevision='%s' WHERE idproyecto=' ".$idproyecto."'",
 mysql_real_escape_string($vendidasTotales), date($anio."-".$mes."-".$dia));
mysql_query($actualizarProyecto);
header("Location: ../".$_SESSION["pageFrom"].".php");
}
?>