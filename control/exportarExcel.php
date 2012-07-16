<?php

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$tipo=$_POST["tipo"];
header("Content-type: application/vnd.ms-excel; name='excel'");
if($tipo=="lista"){
header("Content-Disposition: filename=".$fecha."_listaProyectos.xls");
} else if($tipo=="resumen"){
header("Content-Disposition: filename=".$fecha."_resumenProyectos.xls");
}
header("Pragma: no-cache");
header("Expires: 0");
echo $_POST['datos_a_enviar'];
?>