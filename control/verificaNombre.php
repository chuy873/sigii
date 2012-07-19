<?php
/*
 * Control verificaNombre
* Se recibe la peticion por AJAX para verificar si el nombre de un proyecto o modelo ya existe.
*/
include "../clases/Usuarios.php";
session_start();
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision"
		|| $usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis"  )) {
	header("Location: ../bienvenido.php");
}
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$nombre= $_REQUEST["nombre"];
if(isset($_POST["modelo"])){
	$sql=sprintf("SELECT * FROM modelo WHERE nombre = '%s' AND idmodelo != '".$_POST["modelo"]."'",
	mysql_real_escape_string($nombre));
} else if(isset($_POST["proyecto"])) {
$sql=sprintf("SELECT * FROM proyecto WHERE nombre = '%s' AND idproyecto != '".$_POST["proyecto"]."'",
mysql_real_escape_string($nombre));
} else {
	$sql=sprintf("SELECT * FROM proyecto WHERE nombre = '%s'",
			mysql_real_escape_string($nombre));
} 
$result = mysql_query($sql);
	if ($result) {
		if(mysql_num_rows($result)>0){				
		header("Content-Type: text/html; charset=iso-8859-1");
						echo "false";															
					} else {
					echo "true";
					}
	}