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
$datosUsuarios = "SELECT * FROM usuarios WHERE username='".$username."'";
$result=mysql_query($datosUsuarios);

if (mysql_num_rows($result)>0){
    echo "false";
} else {
    echo "true";
}
?>