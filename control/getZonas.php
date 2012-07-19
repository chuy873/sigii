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
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$ciudad=$_POST["zona"];
$sql="SELECT * FROM zona WHERE ciudad = '".$ciudad."' ORDER BY subzona ASC";
$result = mysql_query($sql);
	if (!$result) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						header("Content-Type: text/html; charset=iso-8859-1");
						echo "<select class='span2' name='subzona' id='subzonaSelect'>";									
						while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {	
						echo "<option value='".$data["idzona"]."'>".$data["subzona"]."</option>";										
						}	
						echo "</select>";
						
					}
}
?>