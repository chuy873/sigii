<?php
/*
 * Control getZonas
* Se recibe la peticion por AJAX para obtener las subzonas, de acuerdo a una ciudad.
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
$nombre=$_POST["nombre"];
if(isset($_POST["modelo"])){
	$sql="SELECT * FROM modelo WHERE nombre = '".$nombre."' AND idmodelo != '".$_POST["modelo"]."'";
} else if(isset($_POST["proyecto"])) {
$sql="SELECT * FROM proyecto WHERE nombre = '".$nombre."' AND idproyecto != '".$_POST["proyecto"]."'";
} else {
	$sql="SELECT * FROM proyecto WHERE nombre = '".$nombre."'";
} 
$result = mysql_query($sql);
	if ($result) {
		if(mysql_num_rows($result)>0){				
		header("Content-Type: text/html; charset=iso-8859-1");
						echo "1";															
					}
	}