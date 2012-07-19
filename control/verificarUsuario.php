<?php
include "../clases/Usuarios.php";
session_start();
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision"
		|| $usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis"
		|| $usuariologueado->getTipo()=="cliente"   )) {
	header("Location: ../bienvenido.php");
}
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$username = $_REQUEST["username"];
if(isset($_POST["usuario"])){
	$datosUsuarios =sprintf("SELECT * FROM usuarios WHERE username = '%s' AND idusuarios != '".$_POST["usuario"]."'",
			mysql_real_escape_string($username));
} else {
	$datosUsuarios = sprintf("SELECT * FROM usuarios WHERE username = '%s'",
			mysql_real_escape_string($username));
}
$result=mysql_query($datosUsuarios);
if($result){
if (mysql_num_rows($result)>0){
	header("Content-Type: text/html; charset=iso-8859-1");
	echo "false";
} else {
	echo "true";
}
}
?>